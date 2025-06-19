@extends('layouts.ap')

@section('content')
<h3>Mis Comisiones</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Servicio</th>
            <th>Agenda</th>
            <th>Monto</th>
            <th>Estado</th>
            <th>Fecha de Pago</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comisiones as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->servicio->name ?? 'N/A' }}</td>
                <td>{{ $c->agenda->codigo ?? 'N/A' }}</td>
                <td>Bs {{ number_format($c->monto, 2) }}</td>
                <td>
                    @if ($c->estado === 'pagado')
                        <span class="text-success">Pagado</span>
                    @else
                        <span class="text-warning">Pendiente</span>
                    @endif
                </td>
                <td>{{ $c->fecha_pago ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
