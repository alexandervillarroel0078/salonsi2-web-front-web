@extends('layouts.ap')
@section('content')
<div class="container mt-4">
    <h4>Listado de Sucursales</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('sucursales.create') }}" class="btn btn-success mb-3">+ Nueva Sucursal</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sucursales as $sucursal)
            <tr>
                <td>{{ $sucursal->id }}</td>
                <td>{{ $sucursal->nombre }}</td>
                <td>{{ $sucursal->direccion }}</td>
                <td>{{ $sucursal->telefono }}</td>
                <td>
                    <a href="{{ route('sucursales.show', $sucursal->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('sucursales.destroy', $sucursal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar sucursal?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
