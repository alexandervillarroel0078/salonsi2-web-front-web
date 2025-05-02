@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Nuevo Horario</h2>

    <form action="{{ route('horarios.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Personal</label>
            <select name="personal_id" class="form-control" required>
                <option value="">Seleccionar personal</option>
                @foreach($personals as $personal)
                    <option value="{{ $personal->id }}">{{ $personal->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Hora de Inicio</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Hora de Fin</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label>¿Disponible?</label>
            <input type="checkbox" name="available" value="1">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
