@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Horarios</h2>

    @can('crear horarios')
        <a href="{{ route('horarios.create') }}" class="btn btn-primary mb-3">Nuevo Horario</a>
    @endcan

    {{-- Filtros y Exportación --}}
    <form method="GET" action="{{ route('horarios.index') }}" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label for="fecha" class="form-label">Filtrar por fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
        </div>

        <div class="col-md-3">
            <label for="personal_id" class="form-label">Personal</label>
            <select name="personal_id" id="personal_id" class="form-select">
                <option value="">Todos</option>
                @foreach($personals as $personal)
                    <option value="{{ $personal->id }}" {{ request('personal_id') == $personal->id ? 'selected' : '' }}>
                        {{ $personal->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="disponible" class="form-label">Disponible</label>
            <select name="disponible" id="disponible" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('disponible') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('disponible') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="search" class="form-label">Buscar por fecha (texto)</label>
            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}">
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    {{-- Botón de exportar separado, mantiene los filtros actuales --}}
    <form method="GET" action="{{ route('horarios.export') }}" target="_blank" class="row g-2 align-items-end mb-4">
    @foreach(request()->except('format') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <div class="col-auto">
        <label for="format" class="form-label">Formato</label>
        <select name="format" id="format" class="form-select">
            <option value="html">HTML</option>
            <option value="pdf">PDF</option>
        </select>
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-success">Exportar</button>
    </div>
</form>


    {{-- Tabla de resultados --}}
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
                    @can('editar horarios')
                        <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    @endcan

                    @can('eliminar horarios')
                        <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este horario?')">Eliminar</button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $horarios->appends(request()->query())->links() }}
    </div>
</div>
@endsection
