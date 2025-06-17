@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detalle de la Cita Asignada</h2>

    <div class="card p-4">
        <p><strong>Código:</strong> {{ $agenda->codigo }}</p>
        <p><strong>Fecha:</strong> {{ $agenda->fecha }}</p>
        <p><strong>Hora:</strong> {{ $agenda->hora }}</p>
        <p><strong>Cliente:</strong> {{ $agenda->clientes->first()->name ?? '—' }}</p>
        <p><strong>Tipo de atención:</strong> {{ ucfirst($agenda->tipo_atencion) }}</p>
        <p><strong>Ubicación:</strong> {{ $agenda->ubicacion ?? '—' }}</p>
        <p><strong>Notas:</strong> {{ $agenda->notas ?? 'Sin observaciones' }}</p>
        <p><strong>Duración total:</strong> {{ $agenda->duracion }} minutos</p>
        <p><strong>Precio total:</strong> Bs {{ $agenda->precio_total }}</p>
        <p><strong>Estado:</strong> 
            <span class="badge bg-{{ $agenda->estado === 'en_curso' ? 'warning' : ($agenda->estado === 'finalizada' ? 'success' : 'info') }}">
                {{ ucfirst($agenda->estado) }}
            </span>
        </p>

        <hr>
        <h5>Servicios asignados:</h5>
        <ul>
            @foreach($agenda->servicios as $servicio)
                <li>
                    {{ $servicio->name }} (x{{ $servicio->pivot->cantidad }})
                    <br>
                    <small><strong>Asignado a:</strong> 
                        {{ $servicio->personal->firstWhere('id', $servicio->pivot->personal_id)?->name ?? 'No asignado' }}
                    </small>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('personals.mis_citas') }}" class="btn btn-secondary mt-3">← Volver</a>
    </div>
</div>
@endsection
