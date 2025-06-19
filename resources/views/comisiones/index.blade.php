@extends('layouts.ap')

@section('content')
<h3>Listado de Comisiones</h3>

<a href="{{ route('comisiones.create') }}" class="btn btn-primary mb-3">Nueva Comisión</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Agenda</th>
            <th>Servicio</th>
            <th>Personal</th>
            <th>Monto</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comisiones as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->agenda->codigo ?? 'N/A' }}</td>
            <td>{{ $c->servicio->name ?? 'N/A' }}</td>
            <td>{{ $c->personal->name ?? 'N/A' }}</td>
            <td>Bs {{ number_format($c->monto, 2) }}</td>
            <td>{{ ucfirst($c->estado) }}</td>
            <td>
                <a href="{{ route('comisiones.edit', $c) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('comisiones.destroy', $c) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
