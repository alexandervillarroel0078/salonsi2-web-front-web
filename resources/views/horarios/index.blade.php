@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Horarios</h2>

    <form method="GET" action="{{ route('horarios.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por fecha" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Personal</th>
                <th>Fecha</th>
                <th>Hora de Inicio</th>
                <th>Hora de Fin</th>
                <th>Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
            <tr>
                <td>{{ $horario->id }}</td>
                <td>{{ $horario->personal->name }}</td>
                <td>{{ $horario->date }}</td>
                <td>{{ $horario->start_time }}</td>
                <td>{{ $horario->end_time }}</td>
                <td>{{ $horario->available ? 'Sí' : 'No' }}</td>
                <td>
                    <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este horario?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $horarios->links() }}
    </div>
</div>
@endsection
