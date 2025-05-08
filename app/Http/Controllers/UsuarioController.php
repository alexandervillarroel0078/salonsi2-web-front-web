<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\updateUsuarioRequest;
use App\Models\Empleado;
use App\Models\User;
use App\Models\Cliente;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Permission\Models\Role;
use App\Traits\BitacoraTrait;

class UsuarioController extends Controller
{
    use BitacoraTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all();
        $empleados = Empleado::all();
        $residentes = \App\Models\Residente::all();
        $empleados = \App\Models\Personal::all();
        $clientes = \App\Models\Cliente::all(); 
        return view('users.create', compact('roles', 'empleados', 'clientes'));
    }

    public function store(StoreUsuarioRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validar que no se seleccionen ambos
            if ($request->filled('empleado_id') && $request->filled('residente_id')) {
                return back()->withErrors(['Ambos campos no pueden estar llenos. Selecciona solo un empleado o un residente.'])->withInput();
            }

            $user = new User();
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'empleado_id' => $request->empleado_id,
                'residente_id' => $request->residente_id,
                'email_verified_at' => null,
                'password' => Hash::make($request->password)
            ]);
            $user->save();

            // Asignar rol
            $user->assignRole($request->role);

            $this->registrarEnBitacora('Usuario creado', $user->id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $this->registrarEnBitacora('Error al crear usuario: ' . $e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'Usuario registrado con éxito.');
    }




    public function show(string $id)
    {
        //
    }


    public function edit(User $user)
{
    $empleados = \App\Models\Personal::all();
    $roles = Role::all();
    return view('users.edit', compact('user', 'roles', 'empleados'));
}



public function update(updateUsuarioRequest $request, User $user)
{
    try {
        DB::beginTransaction();

        if ($request->filled('empleado_id') && $request->filled('residente_id')) {
            return back()->withErrors(['No se puede asignar un empleado y un residente al mismo tiempo.'])->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'empleado_id' => $request->empleado_id,
            'residente_id' => $request->residente_id,
        ]);

        $user->syncRoles([$request->role]);
        $this->registrarEnBitacora('Usuario actualizado', $user->id);
        DB::commit();
    } catch (Exception $e) {
        DB::rollBack();
        $this->registrarEnBitacora('Error al actualizar usuario: ' . $e->getMessage());
    }

    return redirect()->route('users.index')->with('success', 'El usuario se ha actualizado');
}


    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user->activo == 1) {
            User::where('id', $user->id)->update([
                'activo' => 0
            ]);
            $this->registrarEnBitacora('Usuario desactivado: ', $user->id);
            return redirect()->route('users.index')->with('success', 'El usuario ha sido dado de baja');
        }

        return redirect()->route('users.index');
    }
}
