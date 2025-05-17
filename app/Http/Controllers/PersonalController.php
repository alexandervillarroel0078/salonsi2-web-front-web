<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;
use App\Models\CargoEmpleado;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;

class PersonalController extends Controller
{
    use BitacoraTrait;

    // Mostrar todos los empleados con paginación y búsqueda
    public function index(Request $request)
    {
        $query = Personal::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $personals = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('personals.index', compact('personals'));
    }

    // Mostrar formulario para crear un nuevo personal
    public function create()
    {
        // $cargos = \App\Models\CargoEmpleado::all(); // usa el namespace completo si no tienes el use
        $cargos = CargoEmpleado::all();
        $especialidades = Service::all();
        $services = Service::all();
        return view('personals.create', compact('cargos', 'especialidades', 'services'));
    }


    // Almacenar un nuevo personal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personals',
            'phone' => 'nullable|string|max:255',
            'status' => 'boolean',
            'photo_file' => 'nullable|image|max:2048',
            'cargo_empleado_id' => 'required|exists:cargo_empleados,id',
            'fecha_ingreso' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
        ]);

        // Guardar imagen
        if ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('personals', 'public');
            $validated['photo_url'] = 'storage/' . $path;
        }

        // Crear personal
        $personal = Personal::create($validated);

        // Asociar servicios
        $personal->services()->sync($request->input('specialties', []));

        $this->registrarEnBitacora('Crear personal');

        return redirect()->route('personals.index')->with('message', 'Personal creado con éxito');
    }



    // Mostrar formulario para editar un personal
    public function edit(Personal $personal)
    {
        $services = Service::all();
        $cargos = CargoEmpleado::all();

        return view('personals.edit', compact('personal', 'services', 'cargos'));
    }
    // Actualizar un personal existente
    public function update(Request $request, Personal $personal)
    {
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
        ]);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personals,email,' . $personal->id,
            'phone' => 'nullable|string|max:255',
            'status' => 'boolean',
            'photo_url' => 'nullable|image|max:2048',

            'cargo_empleado_id' => 'required|exists:cargo_empleados,id',
            'fecha_ingreso' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
        ]);
        if ($request->hasFile('photo_url')) {
            $path = $request->file('photo_url')->store('personals', 'public');
            $validated['photo_url'] = 'storage/' . $path;
        }

        $personal->update($validated);

        // Actualizar servicios seleccionados
        $personal->services()->sync($request->input('specialties', []));

        $this->registrarEnBitacora('Actualizar personal', $personal->id);

        return redirect()->route('personals.index')->with('message', 'Personal actualizado con éxito');
    }


    // Eliminar un personal
    public function destroy(Personal $personal)
    {
        $personal->delete();
        $this->registrarEnBitacora('Eliminar personal', $personal->id);

        return redirect()->route('personals.index')->with('message', 'Personal eliminado con éxito');
    }

 public function searchAjax(Request $request)
{
    $query = $request->get('query');

    $personals = Personal::where('name', 'like', "%{$query}%")
        ->orWhere('email', 'like', "%{$query}%")
        ->with('cargoEmpleado')
        ->take(20)
        ->get();

    $html = '';

    foreach ($personals as $personal) {
        $html .= '<tr>';
        $html .= '<td>' . $personal->id . '</td>';
        $html .= '<td>' . $personal->name . '</td>';
        $html .= '<td>' . $personal->email . '</td>';
        $html .= '<td>' . $personal->phone . '</td>';

        $cargo = $personal->cargoEmpleado ? $personal->cargoEmpleado->cargo : 'Sin cargo';
        $html .= '<td><span class="badge bg-info text-dark">' . $cargo . '</span></td>';

        $estado = $personal->status ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
        $html .= '<td>' . $estado . '</td>';

        $img = $personal->photo_url ?? asset('images/default-profile.png');
        $html .= '<td><img src="' . $img . '" class="rounded-circle" style="width: 50px; height: 50px;"></td>';

        $html .= '<td>';
        $html .= '<a href="' . route('personals.edit', $personal->id) . '" class="btn btn-sm btn-warning">Editar</a>';
        $html .= '<form action="' . route('personals.destroy', $personal->id) . '" method="POST" style="display:inline;">';
        $html .= csrf_field();
        $html .= method_field('DELETE');
        $html .= '<button class="btn btn-sm btn-danger" onclick="return confirm(\'¿Eliminar este personal?\')">Eliminar</button>';
        $html .= '</form>';
        $html .= '</td>';

        $html .= '</tr>';
    }

    if ($personals->isEmpty()) {
        $html = '<tr><td colspan="8" class="text-center">No hay resultados.</td></tr>';
    }

    return $html;
}



    // API: Obtener todos los personales en formato JSON
    public function getList()
    {
        $personals = Personal::orderBy('created_at', 'desc')->get();

        return response()->json($personals);
    }



    public function export(Request $request)
    {
        // Obtener las columnas seleccionadas, si no se selecciona ninguna, asignar las predeterminadas
        $columns = $request->input('columns', ['id', 'name', 'email']); // Asignar las predeterminadas si no hay selección

        // Obtener los datos de personal con las columnas seleccionadas
        $query = Personal::select($columns);

        // Aplicar los filtros si es necesario
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Obtener los datos
        $personals = $query->orderBy('created_at', 'desc')->get();

        // Si el formato es PDF
        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('personals.pdf', compact('personals', 'columns'));
            return $pdf->download('personals.pdf');
        }

        // Si el formato es HTML
        if ($request->format === 'html') {
            return view('personals.html', compact('personals', 'columns'));
        }

        // Si no se especifica el formato, retorna HTML por defecto
        return view('personals.html', compact('personals', 'columns'));
    }
}
