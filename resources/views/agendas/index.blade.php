@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Agenda de Servicios</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Personal Asignado</th>
                <th>Lugar</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agendas as $agenda)
                <tr>
                    <td>{{ $agenda->fecha }}</td>
                    <td>{{ $agenda->hora }}</td>
                    <td>{{ $agenda->cliente->nombre ?? '-' }}</td>
                    <td>{{ $agenda->servicio->name ?? '-' }}</td>
                    <td>{{ $agenda->personal->name ?? '-' }}</td>
                    <td>{{ ucfirst($agenda->tipo_atencion) }}</td>
                    <td>{{ $agenda->notas ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $agendas->links() }}
    </div>
</div>
@endsection
