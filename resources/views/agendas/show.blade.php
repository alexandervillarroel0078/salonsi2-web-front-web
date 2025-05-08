@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detalle de la Cita</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $agenda->cliente->name }}</p>
            <p><strong>Personal Asignado:</strong> {{ $agenda->personal->name }}</p>
            <p><strong>Fecha:</strong> {{ $agenda->fecha }}</p>
            <p><strong>Hora:</strong> {{ $agenda->hora }}</p>
            <p><strong>Ubicación:</strong> {{ ucfirst($agenda->tipo_atencion) }}</p>

            @if($agenda->tipo_atencion === 'domicilio')
                <p><strong>Dirección:</strong> {{ $agenda->ubicacion }}</p>
            @endif

            <p><strong>Estado:</strong> 
                <span class="badge bg-primary text-white">{{ ucfirst($agenda->estado) }}</span>
            </p>

            <p><strong>Duración estimada:</strong> {{ $agenda->duracion }} minutos</p>
            <p><strong>Precio total:</strong> Bs {{ number_format($agenda->precio_total, 2) }}</p>

            <hr>
            <h5>Servicios incluidos:</h5>
            <ul>
                @foreach($agenda->servicios as $servicio)
                    <li>{{ $servicio->name }} ({{ $servicio->duration_minutes }} min, Bs {{ $servicio->has_discount ? $servicio->discount_price : $servicio->price }})</li>
                @endforeach
            </ul>

            @if($agenda->observaciones_cliente)
                <hr>
                <p><strong>Observaciones:</strong> {{ $agenda->observaciones_cliente }}</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('agendas.index') }}" class="btn btn-secondary">Volver</a>
                <a href="{{ route('agendas.edit', $agenda->id) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
