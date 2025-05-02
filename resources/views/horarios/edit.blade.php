@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Horario</h2>

    <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Personal</label>
            <select name="personal_id" class="form-control" required>
                <option value="">Seleccionar personal</option>
                @foreach($personals as $personal)
                    <option value="{{ $personal->id }}" {{ $horario->personal_id == $personal->id ? 'selected' : '' }}>{{ $personal->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="date" class="form-control" value="{{ $horario->date }}" required>
        </div>

        <div class="form-group">
            <label>Hora de Inicio</label>
            <input type="time" name="start_time" class="form-control" value="{{ $horario->start_time }}" required>
        </div>

        <div class="form-group">
            <label>Hora de Fin</label>
            <input type="time" name="end_time" class="form-control" value="{{ $horario->end_time }}" required>
        </div>

        <div class="form-group">
            <label>¿Disponible?</label>
            <input type="checkbox" name="available" value="1" {{ $horario->available ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
