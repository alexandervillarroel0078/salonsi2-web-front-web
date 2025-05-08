@extends('layouts.ap')
<!-- En tu Blade layout (ej: layouts/ap.blade.php) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Asignar Horario Semanal</h4>

    <form method="POST" action="{{ route('horarios.store') }}">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="form-group mb-3">
                    <label><strong>Seleccionar Personal</strong></label>
                    <select name="personal_id" class="form-control" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($personals as $personal)
                        <option value="{{ $personal->id }}">{{ $personal->name }}</option>
                        @endforeach
                    </select>
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
                            $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            @endphp

                            @foreach($dias as $index => $dia)
                            <tr>
                                <td><strong>{{ $dia }}</strong></td>
                                <td>
    <input type="text" name="horarios[{{ strtolower($dia) }}][inicio]" class="form-control hora-picker">
</td>
<td>
    <input type="text" name="horarios[{{ strtolower($dia) }}][fin]" class="form-control hora-picker">
</td>

                                <td>
                                    <select name="horarios[{{ strtolower($dia) }}][disponible]" class="form-select">
                                        <option value="1">Sí</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
    <button type="submit" class="btn btn-success px-4">
        <i class="fas fa-save me-1"></i> Guardar Horario
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