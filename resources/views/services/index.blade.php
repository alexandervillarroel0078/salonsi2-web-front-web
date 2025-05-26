@extends('layouts.ap')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('services.searchAjax') }}",
                method: 'GET',
                data: {
                    query: query
                },
                success: function(data) {
                    $('#tbody-services').html(data);
                },
                error: function() {
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
                    <label for="search" class="form-label">
                        Buscar
                        <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" title="Busca por nombre o categoría del servicio"></i>
                    </label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Ej. Corte de cabello, Facial, Manicure...">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </div>
                </div>

                {{-- Estado --}}
                <div class="col-md-2">
                    <label for="estado" class="form-label">
                        Estado
                        <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" title="Filtra servicios activos o inactivos"></i>
                    </label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                {{-- Formato de exportación --}}
                <div class="col-md-2">
                    <label for="format" class="form-label">
                        Formato
                        <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" title="Selecciona el formato de exportación de datos"></i>
                    </label>
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
                {{-- Botón Exportar CSV --}}
                <div class="col-md-2 d-grid">
                 {{--  <a href="{{ route('services.export.csv') }}" class="btn btn-outline-success">Exportar CSV</a>--}}
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DE FILTROS AVANZADOS --}}
    <div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="GET" action="{{ route('services.index') }}">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="modalFiltrosLabel">
                            Filtros Avanzados
                            <i class="fas fa-info-circle text-secondary" data-bs-toggle="tooltip" title="Refina tu búsqueda con los filtros más relevantes"></i>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            {{-- Nombre o categoría --}}
                            <div class="col-md-4">
                                <label class="form-label">Nombre o Categoría</label>
                                <input type="text" name="search" class="form-control" placeholder="Ej. Corte, Facial, etc.">
                            </div>

                            {{-- Rango de Precios en una fila --}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Precio mínimo</label>
                                        <input type="number" name="min_price" step="0.01" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Precio máximo</label>
                                        <input type="number" name="max_price" step="0.01" class="form-control">
                                    </div>
                                </div>
                            </div>


                            {{-- Con descuento --}}
                            <div class="col-md-4">
                                <label class="form-label">Descuento</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="con_descuento" id="con_descuento">
                                    <label class="form-check-label" for="con_descuento">Solo con descuento</label>
                                </div>
                            </div>

                            {{-- Duración --}}
                            <div class="col-md-4">
                                <label class="form-label">Duración mínima (min)</label>
                                <input type="number" name="min_duracion" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Duración máxima (min)</label>
                                <input type="number" name="max_duracion" class="form-control">
                            </div>

                            {{-- Tipo de atención --}}
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Atención</label>
                                <select name="tipo_atencion" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="salon">En salón</option>
                                    <option value="domicilio">A domicilio</option>
                                </select>
                            </div>

                            {{-- Disponibilidad --}}
                            <div class="col-md-4">
                                <label class="form-label">Disponibilidad</label>
                                <select name="disponibilidad" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="disponible">Disponible</option>
                                    <option value="agotado">Agotado</option>
                                </select>
                            </div>


                            {{-- Ordenar por --}}
                            <div class="col-md-4">
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


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
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
@push('js')
<script>
    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>

@endpush