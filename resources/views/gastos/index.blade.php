@extends('layouts.ap')

@section('content')
<h3>Listado de Gastos</h3>

<a href="{{ route('gastos.create') }}" class="btn btn-primary mb-3">Registrar nuevo gasto</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Detalle</th>
            <th>Monto (Bs)</th>
            <th>Fecha</th>
            <th>Categoría</th>
            <th>Agenda</th>
            <th>Registrado por</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gastos as $g)
        <tr>
            <td>{{ $g->id }}</td>
            <td>{{ $g->detalle }}</td>
            <td>{{ number_format($g->monto, 2) }}</td>
            <td>{{ \Carbon\Carbon::parse($g->fecha)->format('d/m/Y') }}</td>
            <td>{{ $g->categoria->nombre ?? 'Sin categoría' }}</td>
            <td>{{ $g->agenda->codigo ?? 'Sin agenda' }}</td>
            <td>{{ $g->user->name ?? 'N/D' }}</td>
            <td>
                <a href="{{ route('gastos.edit', $g) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('gastos.destroy', $g) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este gasto?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
