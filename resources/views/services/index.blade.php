@extends('layouts.ap')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('services.searchAjax') }}",
                method: 'GET',
                data: { query: query },
                success: function (data) {
                    $('#tbody-services').html(data);
                },
                error: function () {
                    console.error('Error en la búsqueda AJAX');
                }
            });
        });
    });
</script>
@endpush
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
                    <label for="search" class="form-label">Buscar</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Nombre o categoría" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </div>
                </div>

                {{-- Estado --}}
                <div class="col-md-2">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                {{-- Formato de exportación --}}
                <div class="col-md-2">
                    <label for="format" class="form-label">Formato</label>
                    <select name="format" id="format" class="form-select">
                        <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="excel" {{ request('format') == 'excel' ? 'selected' : '' }}>Excel</option>
                        <option value="csv" {{ request('format') == 'csv' ? 'selected' : '' }}>CSV</option>
                        <option value="html" {{ request('format') == 'html' ? 'selected' : '' }}>HTML</option>
                        <option value="json" {{ request('format') == 'json' ? 'selected' : '' }}>JSON</option>
                    </select>
                </div>

                {{-- Botón para abrir filtros avanzados --}}
                <div class="col-md-1 d-grid">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                        ⚙️ Más filtros
                    </button>
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

    {{-- MODAL DE FILTROS AVANZADOS --}}
    <div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modalFiltrosLabel">Filtros Avanzados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- ID o Código --}}
                        <div class="col-md-4">
                            <label class="form-label">ID o Código</label>
                            <input type="text" name="codigo" class="form-control">
                        </div>

                        {{-- Categoría / Tipo --}}
                        <div class="col-md-4">
                            <label class="form-label">Categoría / Tipo</label>
                            <select name="categoria" class="form-select">
                                <option value="">Seleccionar...</option>
                                <option value="servicio">Servicio</option>
                                <option value="producto">Producto</option>
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="completado">Completado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

                        {{-- Rango de Precios --}}
                        <div class="col-md-6">
                            <label class="form-label">Precio mínimo</label>
                            <input type="number" step="0.01" name="min_price" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Precio máximo</label>
                            <input type="number" step="0.01" name="max_price" class="form-control">
                        </div>

                        {{-- Fecha específica --}}
                        <div class="col-md-4">
                            <label class="form-label">Fecha específica</label>
                            <input type="date" name="fecha_exacta" class="form-control">
                        </div>

                        {{-- Rango de fechas --}}
                        <div class="col-md-4">
                            <label class="form-label">Desde</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hasta</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>

                        {{-- Ubicación / zona --}}
                        <div class="col-md-6">
                            <label class="form-label">Ubicación / Zona</label>
                            <input type="text" name="ubicacion" class="form-control">
                        </div>

                        {{-- Usuario / Cliente --}}
                        <div class="col-md-6">
                            <label class="form-label">Usuario / Cliente</label>
                            <input type="text" name="cliente" class="form-control">
                        </div>

                        {{-- Personal / Especialista --}}
                        <div class="col-md-6">
                            <label class="form-label">Personal / Especialista</label>
                            <input type="text" name="personal" class="form-control">
                        </div>

                        {{-- Ordenar por --}}
                        <div class="col-md-6">
                            <label class="form-label">Ordenar por</label>
                            <select name="ordenar" class="form-select">
                                <option value="">-- Seleccionar --</option>
                                <option value="nombre_asc">Nombre (A-Z)</option>
                                <option value="nombre_desc">Nombre (Z-A)</option>
                                <option value="precio_asc">Precio (menor a mayor)</option>
                                <option value="precio_desc">Precio (mayor a menor)</option>
                                <option value="fecha_asc">Fecha (más antigua)</option>
                                <option value="fecha_desc">Fecha (más reciente)</option>
                            </select>
                        </div>

                        {{-- Checkbox múltiple --}}
                        <div class="col-12">
                            <label class="form-label">Opciones adicionales</label><br>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="con_descuento" class="form-check-input" id="descuento">
                                <label class="form-check-label" for="descuento">Con descuento</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="destacado" class="form-check-input" id="destacado">
                                <label class="form-check-label" for="destacado">Destacado</label>
                            </div>
                        </div>

                        {{-- Disponibilidad / stock --}}
                        <div class="col-md-6">
                            <label class="form-label">Disponibilidad / Stock</label>
                            <select name="stock" class="form-select">
                                <option value="">Todos</option>
                                <option value="disponible">Disponible</option>
                                <option value="agotado">Agotado</option>
                            </select>
                        </div>

                        {{-- Número de registros por página --}}
                        <div class="col-md-6">
                            <label class="form-label">Registros por página</label>
                            <select name="per_page" class="form-select">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        {{-- Etiqueta o Tag --}}
                        <div class="col-md-6">
                            <label class="form-label">Etiqueta / Tag</label>
                            <input type="text" name="tag" class="form-control">
                        </div>

                        {{-- Método de pago / forma de entrega --}}
                        <div class="col-md-6">
                            <label class="form-label">Método de pago / Entrega</label>
                            <select name="pago_entrega" class="form-select">
                                <option value="">Todos</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="online">Pago en línea</option>
                                <option value="domicilio">Entrega a domicilio</option>
                                <option value="retiro">Retiro en tienda</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" formaction="{{ route('services.index') }}">Aplicar Filtros</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


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
        <tbody id="tbody-services">

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
<div class="d-flex justify-content-center" id="pagination-container">
    {{ $services->appends(['search' => request('search')])->links() }}
</div>

</div>
@endsection