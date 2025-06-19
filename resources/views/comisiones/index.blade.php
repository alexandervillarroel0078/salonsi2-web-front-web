@extends('layouts.ap')

@section('content')
<h3>Listado de Comisiones</h3>


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
                @if ($c->estado === 'pendiente')
                <form method="POST" action="{{ route('comisiones.pagar', $c->id) }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-sm btn-success">
                        Pagar comisión
                    </button>
                </form>
                @else
                <span class="text-success">Pagado</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection