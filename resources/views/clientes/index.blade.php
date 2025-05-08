@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Clientes</h2>

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <!-- Botón para crear un nuevo cliente -->
    @can('crear clientes')
    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Nuevo Cliente</a>
    @endcan
    <!-- 
    <form method="GET" action="{{ route('clientes.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o email" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>-->

    {{-- Contenedor de Filtros y Exportación --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">

                {{-- Buscar por nombre o email --}}
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar por nombre o email</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por nombre o email" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </div>
                </div>

                {{-- Formato de exportación --}}
                <div class="col-md-2">
                    <label for="format" class="form-label">Formato</label>
                    <select name="format" id="format" class="form-select">
                        <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="html" {{ request('format') == 'html' ? 'selected' : '' }}>HTML</option>
                    </select>
                </div>

                {{-- Selección de columnas personalizadas --}}
                <div class="col-md-3">
                    <label for="columns" class="form-label">Seleccionar columnas</label>
                    <div class="form-check">
                        <input type="checkbox" name="columns[]" class="form-check-input" id="col_id" value="id" {{ in_array('id', request('columns', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="col_id">ID</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="columns[]" class="form-check-input" id="col_name" value="name" {{ in_array('name', request('columns', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="col_name">Nombre</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="columns[]" class="form-check-input" id="col_email" value="email" {{ in_array('email', request('columns', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="col_email">Email</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="columns[]" class="form-check-input" id="col_phone" value="phone" {{ in_array('phone', request('columns', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="col_phone">Teléfono</label>
                    </div>
                </div>

                {{-- Botón Filtrar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary" formaction="{{ route('clientes.index') }}">Filtrar</button>
                </div>

                {{-- Botón Exportar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success" formaction="{{ route('clientes.export') }}" formtarget="_blank">Exportar</button>
                </div>

            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Foto</th>

                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Total Citas</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>
                    @if($cliente->photo)
                    <img src="{{ asset('storage/' . $cliente->photo) }}" alt="Foto" class="rounded-circle" width="50" height="50">
                    @else
                    <span class="text-muted">Sin foto</span>
                    @endif
                </td>

                <td>{{ $cliente->name }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->phone }}</td>
                <td>{{ $cliente->agendas_count ?? 0 }}</td>

                <td>{{ $cliente->status ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    @can('editar clientes')
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    @endcan

                    @can('eliminar clientes')
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este cliente?')">Eliminar</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay clientes registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $clientes->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection