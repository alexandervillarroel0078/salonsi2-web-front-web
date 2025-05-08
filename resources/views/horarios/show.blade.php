@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Detalle de Horario de: <strong>{{ $horario->personal->name }}</strong></h4>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img src="{{ $horario->personal->foto ?? 'https://via.placeholder.com/100' }}" 
                         class="rounded-circle img-thumbnail" alt="Foto" width="100" height="100">
                </div>
                <div class="col-md-10">
                    <p><strong>Nombre:</strong> {{ $horario->personal->name }}</p>
                    <p><strong>Especialidad:</strong> {{ $horario->personal->especialidad ?? 'Sin definir' }}</p>
                    <p><strong>Días asignados:</strong>
                        {{ $horarios->pluck('day_name')->unique()->implode(', ') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <strong>Horarios asignados por día</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Fecha</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Disponible</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horarios as $h)
                        <tr>
                            <td>{{ $h->day_name }}</td>
                            <td>{{ $h->date }}</td>
                            <td>{{ \Carbon\Carbon::parse($h->start_time)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($h->end_time)->format('H:i') }}</td>
                            <td>
                                @if ($h->available)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
            ← Volver a la lista
        </a>
    </div>
</div>
@endsection
