@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Servicios</h2>
    @can('crear servicios')
    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Nuevo Servicio</a>
    @endcan
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif



    {{-- Contenedor de Filtros y Exportación --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">

                {{-- Buscar por nombre o categoría --}}
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar por nombre o categoría</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por nombre o categoría" value="{{ request('search') }}">
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
                        <input type="checkbox" name="columns[]" class="form-check-input" id="col_price" value="price" {{ in_array('price', request('columns', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="col_price">Precio</label>
                    </div>

                </div>

                {{-- Botón Filtrar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary" formaction="{{ route('services.index') }}">Filtrar</button>
                </div>

                {{-- Botón Exportar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success" formaction="{{ route('services.export') }}" formtarget="_blank">Exportar</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Botón para Exportar 
    <form method="GET" action="{{ route('services.export') }}" class="d-inline">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <button type="submit" class="btn btn-success" name="format" value="pdf">Exportar a PDF</button>
    </form>-->




    <!-- Formulario de búsqueda 
    <form method="GET" action="{{ route('services.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o categoría" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>-->

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Disponible</th>
                <th>Categoría</th>
                <th>Tipo de Atención</th>

                <th>Duración (min)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td>
                    @if($service->image_path)
                    <img src="{{ $service->image_path }}" width="60" height="60" style="object-fit:cover;">
                    @endif
                </td>
                <td>{{ $service->name }}</td>
                <td>Bs {{ number_format($service->price, 2) }}</td>
                <td>
                    @if($service->has_discount)
                    Bs {{ number_format($service->discount_price, 2) }}
                    @else
                    No
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $service->has_available ? 'success' : 'secondary' }}">
                        {{ $service->has_available ? 'Disponible' : 'No disponible' }}
                    </span>
                </td>

                <td>{{ $service->category ?? 'Sin categoría' }}</td>
                <td>{{ ucfirst($service->tipo_atencion) }}</td>

                <td>{{ $service->duration_minutes }} min</td>
                <td>
                    @can('ver servicios')
                    <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-info">Ver</a>
                    @endcan
                    @can('editar servicios')
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    @endcan
                    @can('eliminar servicios')
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este servicio?')">Eliminar</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No hay servicios registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $services->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection