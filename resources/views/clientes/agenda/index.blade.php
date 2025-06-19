@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    @can('crear citas')
    <a id="btnNuevaCita" href="{{ route('agendas.create') }}" class="btn btn-success mb-3">
        + Nueva Cita
    </a>
    @endcan
    <h3>Mis Citas Agendadas</h3>

    @if ($agendas->isEmpty())
    <p>No tienes citas agendadas.</p>
    @else


    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Servicios</th>
                <th>Personal</th>
                <th>Estado</th>
                <th>Pago</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach($agendas as $agenda)
            <tr>
                <td>{{ $agenda->fecha }}</td>
                <td>{{ $agenda->hora }}</td>
                <td>
                    <ul class="mb-0">
                        @foreach($agenda->servicios as $servicio)
                        <li>{{ $servicio->name }} ({{ $servicio->pivot->cantidad }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    {{ $agenda->personal->pluck('name')->join(', ') ?? 'Sin asignar' }}
                </td>
                <td>
                    <span class="badge 
        @if($agenda->estado === 'pendiente') bg-warning text-dark 
        @elseif($agenda->estado === 'por_confirmar') bg-primary 
        @elseif($agenda->estado === 'finalizada') bg-success 
        @elseif($agenda->estado === 'en_curso') bg-info 
        @else bg-secondary 
        @endif">
                        {{ ucfirst($agenda->estado) }}
                    </span>
                </td>

                <td>
                    @if ($agenda->estado === 'pendiente')
                    <form action="{{ route('pagos.qr', $agenda->id) }}" method="GET" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">Pagar con QR</button>
                    </form>

                    <form action="{{ route('pagos.stripe', $agenda->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-dark">Pagar con Stripe</button>
                    </form>
                    @else
                    <span class="text-muted">Ya pagado</span>
                    @endif
                </td>
                <td>
                    @if ($agenda->estado === 'por_confirmar')
                    <a href="{{ route('cliente.agenda.confirmar', $agenda->id) }}" class="btn btn-sm btn-success">
                        Confirmar y calificar
                    </a>
                    @elseif ($agenda->estado === 'finalizada')
                    <span class="text-success">Completada ✅</span>
                    @elseif ($agenda->estado === 'cancelada')
                    <span class="text-danger">Cancelada</span>
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection