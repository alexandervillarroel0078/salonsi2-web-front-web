@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Gestión de Asistencias del Personal</h4>

        @can('crear asistencias')
        <a href="{{ route('asistencias.create') }}" class="btn btn-success">
            + Registrar Asistencia
        </a>
        @endcan

    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('asistencias.index') }}" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <label><strong>Personal</strong></label>
            <select name="personal_id" class="form-control">
                <option value="">-- Todos --</option>
                @foreach($personals as $personal)
                <option value="{{ $personal->id }}" {{ request('personal_id') == $personal->id ? 'selected' : '' }}>
                    {{ $personal->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label><strong>Mes</strong></label>
            <select name="mes" class="form-control">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->locale('es')->translatedFormat('F') }}
                    </option>
                    @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label><strong>Año</strong></label>
            <select name="año" class="form-control">
                @for($a = now()->year; $a >= now()->year - 5; $a--)
                <option value="{{ $a }}" {{ request('año') == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2 text-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <!-- Tabla -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Rol/Especialidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asistenciasAgrupadas as $personal)
                    <tr>
                        <td>
                            <img src="{{ $personal->photo_url ?? 'https://via.placeholder.com/40' }}" class="rounded-circle" width="40" height="40">
                        </td>
                        <td>{{ $personal->name }}</td>
                        <td>{{ $personal->cargo->cargo ?? '—' }}</td>
                        <td>
                            @can('ver asistencias')
                            <a href="{{ route('asistencias.show', $personal->id) }}" class="btn btn-sm btn-outline-info">
                                Ver asistencia
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay registros de asistencia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection