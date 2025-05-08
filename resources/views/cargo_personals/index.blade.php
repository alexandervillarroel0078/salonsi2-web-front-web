<!-- resources/views/cargo_empleados/index.blade.php -->
@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Cargos del Personal</h2>
        @can('crear cargos')
        <a href="{{ route('cargos.create') }}" class="btn btn-primary">Nuevo Cargo</a>
        @endcan
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cargos as $cargo)
            <tr>
                <td>{{ $cargo->cargo }}</td>
                <td>
                    <span class="badge {{ $cargo->estado ? 'bg-success' : 'bg-danger' }}">
                        {{ $cargo->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td>
                    @can('editar cargos')
                    <a href="{{ route('cargos.edit', $cargo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    @endcan
                    @can('eliminar cargos')
                    <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este cargo?')">Eliminar</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No hay cargos registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection