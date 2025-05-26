@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Productos e Insumos</h4>

    @can('crear productos')
    <a href="{{ route('productos.create') }}" class="btn btn-success mb-3">+ Nuevo Producto</a>
    @endcan

    {{-- Contenedor de Filtros y Exportación --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                {{-- Búsqueda por nombre o descripción --}}
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar producto</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Nombre o descripción" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </div>
                </div>
                {{-- Filtro por categoría --}}
                <div class="col-md-2">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="">Todas</option>
                        <option value="Cabello" {{ request('categoria') == 'Cabello' ? 'selected' : '' }}>Cabello</option>
                        <option value="Uñas" {{ request('categoria') == 'Uñas' ? 'selected' : '' }}>Uñas</option>
                        <option value="Piel" {{ request('categoria') == 'Piel' ? 'selected' : '' }}>Piel</option>
                        <option value="Cejas" {{ request('categoria') == 'Cejas' ? 'selected' : '' }}>Cejas</option>
                        <option value="Depilación" {{ request('categoria') == 'Depilación' ? 'selected' : '' }}>Depilación</option>
                        <option value="Otros" {{ request('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                </div>
                {{-- Filtro por tipo --}}
                <div class="col-md-2">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="consumible" {{ request('tipo') == 'consumible' ? 'selected' : '' }}>Consumible</option>
                        <option value="equipo" {{ request('tipo') == 'equipo' ? 'selected' : '' }}>Equipo</option>
                    </select>
                </div>
                {{-- Formato de exportación --}}
                <div class="col-md-2">
                    <label for="format" class="form-label">Formato</label>
                    <select name="format" id="format" class="form-select">
                        <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="html" {{ request('format') == 'html' ? 'selected' : '' }}>HTML</option>
                        <option value="excel" {{ request('format') == 'Excel' ? 'selected' : '' }}>Excel</option>
                    </select>
                </div>
                {{-- Botón Filtrar --}}
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary" formaction="{{ route('productos.index') }}">Filtrar</button>
                </div>
                {{-- Botón Exportar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success" formaction="{{ route('productos.export') }}" formtarget="_blank">Exportar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de productos --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Tipo</th>
                        <th>Stock</th>
                        <th>Unidad</th>
                        <th>Stock mínimo</th>
                        <th>Descripción</th>
                        <th>Alertas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria }}</td>
                        <td>{{ ucfirst($producto->tipo) }}</td>
                        <td>
                            {{ $producto->stock }}
                            @if($producto->stock <= $producto->stock_minimo)
                                <span class="badge bg-danger">¡Bajo!</span>
                            @endif
                        </td>
                        <td>{{ $producto->unidad }}</td>
                        <td>{{ $producto->stock_minimo }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>
                            @if($producto->stock <= $producto->stock_minimo)
                                <span class="badge bg-warning text-dark">Reponer stock</span>
                            @endif
                        </td>
                        <td>
                            @can('editar productos')
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            @endcan
                            @can('eliminar productos')
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-3">
                {{ $productos->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
