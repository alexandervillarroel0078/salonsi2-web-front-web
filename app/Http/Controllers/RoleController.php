<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Traits\BitacoraTrait;

class RoleController extends Controller
{
    use BitacoraTrait;

    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permisos = Permission::all();
        return view('roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1'
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            $role->syncPermissions($request->permissions);

            $this->registrarEnBitacora('Rol creado', $role->id); // ← antes del commit


            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }

       
    }

    public function edit(Role $role)
    {
        $permisos = Permission::all();
        $permisosRol = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permisos', 'permisosRol'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array|min:1'
        ]);

        DB::beginTransaction();
        try {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            $this->registrarEnBitacora('Rol actualizado', $role->id);

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
        }

         
    }

    public function destroy(Role $role)
    {
        $role->delete();
        $this->registrarEnBitacora('Rol eliminado', $role->id);

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
