@extends('layouts.ap')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Editar Horario Semanal de: <strong>{{ $personal->name }}</strong></h4>

    <form method="POST" action="{{ route('horarios.update', $personal->id) }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="form-group mb-3">
                    <label><strong>Personal</strong></label>
                    <input type="text" class="form-control" value="{{ $personal->name }}" readonly>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dias = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
                            @endphp

                            @foreach($dias as $dia)
                                @php
                                    $registro = $horarios->firstWhere('day_name', ucfirst($dia));
                                @endphp
                                <tr>
                                    <td><strong>{{ ucfirst($dia) }}</strong></td>
                                    <td>
                                        <input type="text" name="horarios[{{ $dia }}][inicio]" class="form-control hora-picker"
                                            value="{{ $registro ? $registro->start_time : '' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="horarios[{{ $dia }}][fin]" class="form-control hora-picker"
                                            value="{{ $registro ? $registro->end_time : '' }}">
                                    </td>
                                    <td>
                                        <select name="horarios[{{ $dia }}][disponible]" class="form-select">
                                            <option value="1" {{ $registro && $registro->available ? 'selected' : '' }}>Sí</option>
                                            <option value="0" {{ !$registro || !$registro->available ? 'selected' : '' }}>No</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save me-1"></i> Actualizar Horario
                    </button>
                    <a href="{{ route('horarios.index') }}" class="btn btn-secondary px-4 ms-2">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    flatpickr(".hora-picker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>
@endsection
