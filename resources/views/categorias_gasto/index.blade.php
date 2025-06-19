@extends('layouts.ap')

@section('content')
<h3>Categorías de Gasto</h3>

<a href="{{ route('categorias-gasto.create') }}" class="btn btn-primary mb-3">Nueva Categoría</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->nombre }}</td>
            <td>{{ $c->descripcion }}</td>
            <td>
                <span class="badge {{ $c->activo ? 'bg-success' : 'bg-secondary' }}">
                    {{ $c->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </td>
            <td>
                <a href="{{ route('categorias-gasto.edit', $c) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('categorias-gasto.destroy', $c) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
