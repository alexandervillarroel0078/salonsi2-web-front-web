@extends('layouts.ap')
<style>
.truncate-text {
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Lista de Combos</h4>

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @can('crear combos')
    <a href="{{ route('combos.create') }}" class="btn btn-primary mb-3">Crear Nuevo Combo</a>
    @endcan

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Precio con descuento</th>
                <th>Servicios Incluidos</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($combos as $combo)
            <tr>
                <td>{{ $combo->id }}</td>
                <td>{{ $combo->name }}</td>
                <td class="truncate-text" title="{{ $combo->description }}">
                    {{ $combo->description }}
                </td>

                <td>Bs. {{ number_format($combo->price, 2) }}</td>
                <td>
                    @if($combo->has_discount && $combo->discount_price)
                    <span class="text-success">Bs. {{ number_format($combo->discount_price, 2) }}</span>
                    @else
                    <span class="text-muted">Sin descuento</span>
                    @endif
                </td>
                <td>
                    @foreach($combo->services as $service)
                    <span class="badge bg-secondary">{{ $service->name }}</span>
                    @endforeach
                </td>
                <td>
                    @if($combo->active)
                    <span class="badge bg-success">Activo</span>
                    @else
                    <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
                <td>
                <a href="{{ route('combos.show', $combo->id) }}" class="btn btn-info btn-sm">Ver</a>
                
                    @can('editar combos')
                    <a href="{{ route('combos.edit', $combo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    @endcan

                    @can('eliminar combos')
                    <form action="{{ route('combos.destroy', $combo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este combo?')">Eliminar</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>



</div>
@endsection