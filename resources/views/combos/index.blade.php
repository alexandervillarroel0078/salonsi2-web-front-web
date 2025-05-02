@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Combos</h2>

    <a href="{{ route('combos.create') }}" class="btn btn-primary mb-3">Nuevo Combo</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Servicios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($combos as $combo)
            <tr>
                <td>{{ $combo->name }}</td>
                <td>{{ number_format($combo->price, 2) }}</td>
                <td>{{ $combo->has_discount ? 'Sí' : 'No' }}</td>
                <td>
                    @foreach($combo->services as $service)
                        <span>{{ $service->name }}</span>{{ !$loop->last ? ',' : '' }}
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('combos.edit', $combo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('combos.destroy', $combo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este combo?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
