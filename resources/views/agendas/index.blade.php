@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Agenda de Servicios</h2>

    <!-- Formulario de búsqueda -->
    <form action="{{ route('agendas.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-control" placeholder="Buscar por fecha">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Personal Asignado</th>
                <th>Lugar</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agendas as $agenda)
                <tr>
                    <td>{{ $agenda->fecha }}</td>
                    <td>{{ $agenda->hora }}</td>
                    <td>{{ $agenda->cliente->name ?? '-' }}</td>
                    <td>{{ $agenda->servicio->name ?? '-' }}</td>
                    <td>{{ $agenda->personal->name ?? '-' }}</td>
                    <td>{{ ucfirst($agenda->tipo_atencion) }}</td>
                    <td>
                        @php $estado = strtolower($agenda->estado); @endphp
                        @switch($estado)
                            @case('completado')
                                <span class="badge bg-success">Completado</span>
                                @break
                            @case('pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                                @break
                            @case('cancelado')
                                <span class="badge bg-danger">Cancelado</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Sin definir</span>
                        @endswitch
                    </td>
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
