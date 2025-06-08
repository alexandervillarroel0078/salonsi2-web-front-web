@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Horarios</h2>

    @can('crear horarios')
    <a href="{{ route('horarios.create') }}" class="btn btn-primary mb-3">Nuevo Horario</a>
    @endcan

    <!-- {{-- Exportación y Filtro en un solo contenedor --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">

                {{-- Fecha --}}
                <div class="col-md-3">
                    <label for="fecha" class="form-label">Filtrar por fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
                </div>

                {{-- Personal --}}
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

                {{-- Buscar texto --}}
                <div class="col-md-2">
                    <label for="search" class="form-label">Buscar por fecha (texto)</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}">
                </div>

                {{-- Formato de exportación --}}
                <div class="col-md-2">
                    <label for="format" class="form-label">Formato</label>
                    <select name="format" id="format" class="form-select">
                        <option value="pdf">PDF</option>
                        <option value="html">HTML</option>
                    </select>
                </div>

                {{-- Botón Filtrar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary" formaction="{{ route('horarios.index') }}">Filtrar</button>
                </div>

                {{-- Botón Exportar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success" formaction="{{ route('horarios.export') }}" formtarget="_blank">Exportar</button>
                </div>

            </form>
        </div>
    </div> -->



    {{-- Tabla de resultados --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <!-- <th>Foto</th> -->
                        <th>Nombre</th>
                        <!-- <th>Cargo</th> -->
                        <!-- <th>Días asignados</th> -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horarios as $horario)
                    <tr>
                       <td>{{ $loop->iteration }}</td>
                        <!-- <td>
                            <img src="{{ $horario->personal->photo_url ?? 'https://via.placeholder.com/40' }}"
                                class="rounded-circle" width="40" height="40" alt="Foto">
                        </td> -->
                        
                        <td>{{ $horario->personal->name }}</td>
                        <!-- <td>{{ $horario->personal->cargoEmpleado->cargo ?? '—' }}</td> -->

                        <!-- <td>{{ ucfirst(substr($horario->day_name, 0, 3)) }}</td> -->
                        <td>
                            @can('ver horarios')
                            <a href="{{ route('horarios.show', $horario->id) }}" class="btn btn-sm btn-outline-info">Ver</a>
                            @endcan
                            @can('editar horarios')
                            <a href="{{ route('horarios.edit', $horario->personal->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




    <div class="d-flex justify-content-center mt-3">
        {{ $horarios->appends(request()->query())->links() }}
    </div>
</div>
@endsection