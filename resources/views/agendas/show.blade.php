@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detalle de la Cita</h3>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Código</th>
                    <td>{{ $agenda->codigo }}</td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td>{{ $agenda->clientes->first()?->name ?? 'Sin cliente' }}</td>
                </tr>
                <tr>
                    <th>Personal Asignado</th>
                    <td>
                        @if ($agenda->personal->isNotEmpty())
                        {{ $agenda->personal->pluck('name')->join(', ') }}
                        @else
                        Sin personal asignado
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ $agenda->fecha }}</td>
                </tr>
                <tr>
                    <th>Hora</th>
                    <td>{{ $agenda->hora }}</td>
                </tr>
                <tr>
                    <th>Tipo de Atención</th>
                    <td>{{ ucfirst($agenda->tipo_atencion) }}</td>
                </tr>
                @if($agenda->tipo_atencion === 'domicilio')
                <tr>
                    <th>Dirección</th>
                    <td>{{ $agenda->ubicacion }}</td>
                </tr>
                @endif
                <tr>
                    <th>Estado</th>
                    <td>
                        <span class="badge bg-primary text-white">{{ ucfirst($agenda->estado) }}</span>
                        <a href="#" class="btn btn-sm btn-success ms-2">Pagar</a>
                    </td>
                </tr>
                <tr>
                    <th>Duración Estimada</th>
                    <td>{{ $agenda->duracion }} minutos</td>
                </tr>
                <tr>
                    <th>Precio Total</th>
                    <td>Bs {{ number_format($agenda->precio_total, 2) }}</td>
                </tr>
                <tr>
                    <th>Notas</th>
                    <td>{{ $agenda->notas ?? 'Sin notas' }}</td>
                </tr>
            </table>

            <h5 class="mt-4">Servicios Incluidos</h5>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Personal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agenda->servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->name }}</td>
                        <td>{{ $servicio->duration_minutes }} min</td>
                        <td>Bs {{ $servicio->has_discount ? $servicio->discount_price : $servicio->price }}</td>
                       <td>{{ $servicio->pivot->cantidad }} {{ $servicio->pivot->cantidad == 1 ? 'persona' : 'personas' }}</td>

                        <td>
                            @php
                            $personal = \App\Models\Personal::find($servicio->pivot->personal_id);
                            @endphp
                            {{ $personal?->name ?? 'N/D' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('agendas.index') }}" class="btn btn-secondary mt-3">
                ← Volver a la lista
            </a>

        </div>
    </div>
</div>
@endsection