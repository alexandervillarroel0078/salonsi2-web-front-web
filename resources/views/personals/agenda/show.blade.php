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
            {{-- resources/views/personals/agenda/show.blade.php --}}
            @foreach ($agenda->servicios as $servicio)
            <tr>
                <td>{{ $servicio->name }}</td>
                <td>{{ $servicio->pivot->cantidad }}</td>
                <td>{{ $servicio->personal->firstWhere('id',$servicio->pivot->personal_id)?->name ?? '—' }}</td>

                {{-- Estado --}}
                <td>
                    @if ($servicio->pivot->finalizado)
                    <span class="badge bg-success">Finalizado</span>
                    @else
                    <span class="badge bg-warning text-dark">Pendiente</span>
                    @endif
                </td>

                {{-- Acciones SOLO si le pertenece y está pendiente --}}
                <td>
                    @if (!$servicio->pivot->finalizado && $servicio->pivot->personal_id == auth()->user()->personal_id)
                    <form method="POST"
                        action="{{ route('personals.servicio.finalizar',
                               [$agenda->id, $servicio->id]) }}"
                        class="d-inline">
                        @csrf
                        @method('PUT')

                        {{-- valoracion opcional, quítalo si no lo necesitas --}}
                        <select name="valoracion" class="form-select form-select-sm d-inline w-auto me-1">
                            <option value="">⭐</option>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}">{{ $i }}⭐</option>
                                @endfor
                        </select>

                        {{-- comentario corto opcional --}}
                        <input name="comentario"
                            placeholder="Comentario"
                            class="form-control form-control-sm d-inline w-25 me-1" />

                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-check-circle"></i> Finalizar
                        </button>
                    </form>
                    @else
                    —
                    @endif
                </td>
            </tr>
            @endforeach

        </ul>

        <a href="{{ route('personals.mis_citas') }}" class="btn btn-secondary mt-3">← Volver</a>
    </div>
</div>
@endsection