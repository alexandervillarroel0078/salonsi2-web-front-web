 @extends('layouts.ap')

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
     $(document).ready(function() {
         $('#search').on('keyup', function() {
             let query = $(this).val();
             $.ajax({
                 url: "{{ route('agendas.searchAjax') }}",
                 method: 'GET',
                 data: {
                     query: query
                 },
                 success: function(data) {
                     $('tbody').html(data);
                 },
                 error: function() {
                     console.error('Error al hacer búsqueda AJAX');
                 }
             });
         });
     });
 </script>
 <!--para usar-->
 <script>
     document.addEventListener('keydown', function(e) {
         if (!e.ctrlKey) return;

         switch (e.code) {
             case 'KeyF': // Ctrl + F
                 e.preventDefault();
                 document.getElementById('search')?.focus();
                 break;

             case 'KeyE': // Ctrl + E
                 e.preventDefault();
                 document.getElementById('btnExportar')?.click();
                 break;

             case 'KeyM': // Ctrl + M
                 e.preventDefault();
                 document.querySelector('button[data-bs-target="#modalFiltros"]')?.click();
                 break;

             case 'KeyL': // Ctrl + L
                 e.preventDefault();
                 document.querySelectorAll('input[type="text"], input[type="date"], select').forEach(el => el.value = '');
                 break;

             case 'KeyN':
                 if (e.ctrlKey && e.altKey) {
                     e.preventDefault();
                     window.location.href = "{{ route('agendas.create') }}";
                 }
                 break;


             case 'KeyH': // Ctrl + H
                 e.preventDefault();
                 const modalHelp = new bootstrap.Modal(document.getElementById('modalAtajos'));
                 modalHelp.show();
                 break;
         }
     });
 </script>
 <!-- para exportar con boton o comando -->
 <script>
     // Atajo para exportar
     document.addEventListener('keydown', function(e) {
         if (e.ctrlKey && e.code === 'KeyE') {
             e.preventDefault();
             document.getElementById('btnExportar')?.click();
         }
     });

     // Atajo para crear nueva cita
     document.addEventListener('keydown', function(e) {
         if (e.ctrlKey && e.code === 'KeyN') {
             e.preventDefault();
             document.getElementById('btnNuevaCita')?.click();
         }
     });
 </script>
 <script>
     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
     tooltipTriggerList.map(function(tooltipTriggerEl) {
         return new bootstrap.Tooltip(tooltipTriggerEl);
     });
 </script>




 @section('content')
 <div class="container mt-4">
     <h4 class="mb-4">Agenda de Citas</h4>

     @can('crear citas')
     <a id="btnNuevaCita" href="{{ route('agendas.create') }}" class="btn btn-success mb-3">
         + Nueva Cita
     </a>
     @endcan

     <!-- Botón flotante con etiqueta arriba -->
     <div class="position-fixed d-flex flex-column align-items-center"
         style="top: 90px; right: 25px; z-index: 1050;">
         <span class="badge bg-info text-dark mb-1" style="font-size: 0.75rem;">Atajos</span>
         <button class="btn btn-outline-info rounded-circle shadow"
             data-bs-toggle="modal" data-bs-target="#modalAtajos"
             data-bs-toggle="tooltip" data-bs-placement="left" title="Ver atajos de teclado disponibles">
             <i class="fas fa-question"></i>
         </button>
     </div>

     {{-- Contenedor de Filtros y Exportación --}}
     <div class="card mb-4 shadow-sm">
         <div class="card-body">
             <form method="GET" class="row g-2 align-items-end">

                 {{-- Buscar por fecha, cliente o personal --}}
                 <div class="col-md-3">
                     <label for="search" class="form-label">
                         Buscar por fecha, cliente o personal
                         <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" title="Ej. 2024-05-01, Juan Pérez, Luisa"></i>
                     </label>
                     <div class="input-group">
                         <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por fecha, cliente o personal" value="{{ request('search') }}">
                         <button class="btn btn-outline-primary" type="submit">Buscar</button>
                     </div>
                 </div>



                 {{-- Botón para abrir filtros avanzados --}}
                 <div class="col-md-2 d-grid mt-4">
                     <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                         ⚙️ Más filtros
                     </button>
                 </div>

                 {{-- Selección de columnas personalizadas --}}
                 <div class="col-md-3 p-3 border rounded bg-light">
                     <label for="columns" class="form-label d-block">
                         Seleccionar columnas
                         <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" title="Elige qué columnas deseas ver o exportar"></i>
                     </label>
                     <div class="row">
                         <div class="col-6">
                             <div class="form-check">
                                 <input type="checkbox" name="columns[]" class="form-check-input" id="col_id" value="id" {{ in_array('id', request('columns', [])) ? 'checked' : '' }}>
                                 <label class="form-check-label" for="col_id">ID</label>
                             </div>
                             <div class="form-check">
                                 <input type="checkbox" name="columns[]" class="form-check-input" id="col_fecha" value="fecha" {{ in_array('fecha', request('columns', [])) ? 'checked' : '' }}>
                                 <label class="form-check-label" for="col_fecha">Fecha</label>
                             </div>
                             <div class="form-check">
                                 <input type="checkbox" name="columns[]" class="form-check-input" id="col_estado" value="estado" {{ in_array('estado', request('columns', [])) ? 'checked' : '' }}>
                                 <label class="form-check-label" for="col_estado">Estado</label>
                             </div>
                         </div>
                         <div class="col-6">
                             <div class="form-check">
                                 <input type="checkbox" name="columns[]" class="form-check-input" id="col_cliente" value="cliente_id" {{ in_array('cliente_id', request('columns', [])) ? 'checked' : '' }}>
                                 <label class="form-check-label" for="col_cliente">Cliente</label>
                             </div>
                             <div class="form-check">
                                 <input type="checkbox" name="columns[]" class="form-check-input" id="col_personal" value="personal_id" {{ in_array('personal_id', request('columns', [])) ? 'checked' : '' }}>
                                 <label class="form-check-label" for="col_personal">Personal</label>
                             </div>
                         </div>
                     </div>
                 </div>
                 {{-- Formato de exportación --}}
                 <div class="col-md-2">
                     <label for="format" class="form-label">
                         Formato
                         <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" title="Selecciona el formato del archivo a exportar (PDF, HTML, Excel o CSV)"></i>
                     </label>
                     <select name="format" id="format" class="form-select">
                         <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                         <option value="html" {{ request('format') == 'html' ? 'selected' : '' }}>HTML</option>
                         <option value="excel" {{ request('format') == 'excel' ? 'selected' : '' }}>Excel</option>
                         <option value="csv" {{ request('format') == 'csv' ? 'selected' : '' }}>CSV</option>
                     </select>
                 </div>
                 {{-- Botón Exportar --}}
                 <div class="col-md-2 d-grid">
                     <button id="btnExportar" type="submit" class="btn btn-success" formaction="{{ route('agendas.export') }}" formtarget="_blank">
                         <i class="fas fa-file-export"></i> Exportar
                     </button>
                 </div>

                 {{-- Botones Exportar por separado (más compactos) --}}
                 <div class="col-md-3 d-flex gap-2">
                     <a href="{{ route('agendas.export.csv') }}" target="_blank" class="btn btn-outline-primary btn-sm flex-grow-1">
                         <i class="fas fa-file-csv"></i> CSV
                     </a>
                     <a href="{{ route('agendas.export.excel') }}" target="_blank" class="btn btn-outline-success btn-sm flex-grow-1">
                         <i class="fas fa-file-excel"></i> Excel
                         <a
                             href="{{ route('agendas.export.pdf', request()->only(['search', 'fecha_inicio', 'fecha_fin', 'cliente_id', 'personal_id', 'estado', 'ubicacion', 'ordenar', 'columns'])) }}"
                             target="_blank"
                             class="btn btn-outline-danger btn-sm">
                             <i class="fas fa-file-pdf"></i> PDF
                         </a>


                 </div>



             </form>
         </div>
     </div>
     {{-- Contenedor para ver los filtros activos --}}
     @if(request()->anyFilled(['fecha_inicio', 'fecha_fin', 'hora_inicio', 'hora_fin', 'cliente_id', 'personal_id', 'estado', 'ubicacion', 'ordenar']))
     <div class="alert alert-info d-flex flex-wrap justify-content-between align-items-center p-2 small">
         <div class="d-flex flex-wrap gap-3 align-items-center">
             <strong class="text-dark me-2">Filtros activos:</strong>

             @if(request('fecha_inicio') || request('fecha_fin'))
             <span class="badge bg-secondary">Fecha: {{ request('fecha_inicio') ?? '...' }} → {{ request('fecha_fin') ?? '...' }}</span>
             @endif

             @if(request('hora_inicio') || request('hora_fin'))
             <span class="badge bg-secondary">Hora: {{ request('hora_inicio') ?? '...' }} → {{ request('hora_fin') ?? '...' }}</span>
             @endif

             @if(request('cliente_id'))
             <span class="badge bg-info">Cliente ID: {{ request('cliente_id') }}</span>
             @endif

             @if(request('personal_id'))
             <span class="badge bg-info">Personal ID: {{ request('personal_id') }}</span>
             @endif

             @if(request('estado'))
             <span class="badge bg-warning text-dark">Estado: {{ ucfirst(request('estado')) }}</span>
             @endif

             @if(request('ubicacion'))
             <span class="badge bg-primary">Ubicación: {{ ucfirst(request('ubicacion')) }}</span>
             @endif

             @if(request('ordenar'))
             <span class="badge bg-success">Orden: {{ str_replace('_', ' ', request('ordenar')) }}</span>
             @endif
         </div>

         <div class="ms-auto">
             <a href="{{ route('agendas.index') }}" class="btn btn-sm btn-outline-danger">Limpiar filtros</a>
         </div>
     </div>
     @endif

     <!-- Tabla de citas -->
     <div class="card shadow-sm">
         <div class="card-body p-0">
             <table class="table table-hover mb-0">
                 <thead class="table-dark">
                     <tr>
                         <th>ID</th>
                         <th>Código</th>

                         <th>Fecha</th>
                         <th>Hora</th>
                         <th>Cliente</th>
                         <th>Personal</th>
                         <th>Servicio(s)</th>
                         <th>Estado</th>
                         <th>Ubicación</th>
                         <th>Acciones</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($agendas as $agenda)
                     <tr>
                         <td>{{ $agenda->id }}</td>
                         <td>{{ $agenda->codigo }}</td>

                         <td>{{ $agenda->fecha }}</td>
                         <td>{{ $agenda->hora }}</td>

                         <td>
                             {{ $agenda->clientes->first()?->name ?? 'Sin cliente' }}
                         </td>

                         <td>
                             {{ $agenda->personal->first()?->name ?? 'Sin personal' }}
                         </td>

                         <td>
                             @if ($agenda->servicios && count($agenda->servicios))
                             @foreach ($agenda->servicios as $servicio)
                             {{ $servicio->name }}{{ !$loop->last ? ', ' : '' }}
                             @endforeach
                             @else
                             -
                             @endif
                         </td>
                         <td>
                             <span class="badge bg-{{ $agenda->estado == 'confirmada' ? 'success' : 'secondary' }}">
                                 {{ ucfirst($agenda->estado) }}
                             </span>
                         </td>
                         <td>{{ ucfirst($agenda->ubicacion) }}</td>
                         <td>
                             @can('ver citas')
                             <a href="{{ route('agendas.show', $agenda->id) }}" class="btn btn-sm btn-outline-info">Ver</a>
                             @endcan

                             @can('editar citas')
                             <a href="{{ route('agendas.edit', $agenda->id) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                             @endcan

                             @can('eliminar citas')
                             <form action="{{ route('agendas.destroy', $agenda->id) }}" method="POST" class="d-inline">
                                 @csrf
                                 @method('DELETE')
                                 <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Cancelar esta cita?')">Cancelar</button>
                             </form>
                             @endcan
                         </td>
                     </tr>
                     @endforeach
                 </tbody>
             </table>
         </div>
     </div>




     <!-- MODAL DE FILTROS AVANZADOS -->
     <div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <form method="GET" action="{{ route('agendas.index') }}">
                     <div class="modal-header bg-light">
                         <h5 class="modal-title" id="modalFiltrosLabel">
                             Filtros Avanzados
                             <i class="fas fa-info-circle text-secondary" data-bs-toggle="tooltip" title="Usa estos filtros para personalizar la búsqueda de citas."></i>
                         </h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                     </div>
                     <div class="modal-body">
                         <div class="row g-3">
                             <!-- Rango de fechas -->
                             <div class="col-md-6">
                                 <label class="form-label">Fecha desde</label>
                                 <input type="date" name="fecha_inicio" class="form-control">
                             </div>
                             <div class="col-md-6">
                                 <label class="form-label">Fecha hasta</label>
                                 <input type="date" name="fecha_fin" class="form-control">
                             </div>
                             <!-- Filtro por Año -->
                             <div class="col-md-4">
                                 <label class="form-label">Año</label>
                                 <select name="año" class="form-select">
                                     <option value="">Todos</option>
                                     @for ($year = now()->year; $year >= 2020; $year--)
                                     <option value="{{ $year }}">{{ $year }}</option>
                                     @endfor
                                 </select>
                             </div>

                             <!-- Filtro por Mes -->
                             <div class="col-md-4">
                                 <label class="form-label">Mes</label>
                                 <select name="mes" class="form-select">
                                     <option value="">Todos</option>
                                     @php
                                     $meses = [
                                     1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
                                     4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
                                     7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
                                     10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                     ];
                                     @endphp

                                     @foreach($meses as $numero => $nombre)
                                     <option value="{{ $numero }}" {{ request('mes') == $numero ? 'selected' : '' }}>{{ $nombre }}</option>
                                     @endforeach

                                 </select>
                             </div>

                             <!-- Filtro por Semana -->
                             <div class="col-md-4">
                                 <label class="form-label">Semana del año</label>
                                 <select name="semana" class="form-select">
                                     <option value="">Todas</option>
                                     @for($w = 1; $w <= 52; $w++)
                                         <option value="{{ $w }}">Semana {{ $w }}</option>
                                         @endfor
                                 </select>
                             </div>

                             <!-- Rango de horas -->
                             <div class="col-md-6">
                                 <label class="form-label">Hora desde</label>
                                 <input type="time" name="hora_inicio" class="form-control">
                             </div>
                             <div class="col-md-6">
                                 <label class="form-label">Hora hasta</label>
                                 <input type="time" name="hora_fin" class="form-control">
                             </div>

                             <!-- Cliente con buscador -->
                             <div class="col-md-6">
                                 <label class="form-label">Cliente</label>
                                 <select name="cliente_id" id="cliente_id" class="form-select select2">
                                     <option value="">-- Seleccionar cliente --</option>
                                     <option value="1">Juan Pérez</option>
                                     <option value="2">María Gómez</option>
                                     <option value="3">Carlos Mendoza</option>
                                 </select>
                             </div>

                             <!-- Personal con buscador -->
                             <div class="col-md-6">
                                 <label class="form-label">Personal</label>
                                 <select name="personal_id" id="personal_id" class="form-select select2">
                                     <option value="">-- Seleccionar personal --</option>
                                     <option value="1">Andrea López</option>
                                     <option value="2">José Camacho</option>
                                     <option value="3">Lucía Rojas</option>
                                 </select>
                             </div>




                             <!-- Estado -->
                             <div class="col-md-6">
                                 <label class="form-label">Estado</label>
                                 <select name="estado" class="form-select">
                                     <option value="">Todos</option>
                                     <option value="pendiente">Pendiente</option>
                                     <option value="confirmada">Confirmada</option>
                                     <option value="finalizada">Finalizada</option>
                                     <option value="cancelada">Cancelada</option>
                                     <option value="en_curso">En curso</option>
                                 </select>
                             </div>

                             <!-- Ubicación -->
                             <div class="col-md-6">
                                 <label class="form-label">Ubicación</label>
                                 <select name="ubicacion" class="form-select">
                                     <option value="">Todas</option>
                                     <option value="salón">Salón</option>
                                     <option value="domicilio">Domicilio</option>
                                 </select>
                             </div>

                             <!-- Ordenar por -->
                             <div class="col-md-6">
                                 <label class="form-label">Ordenar por</label>
                                 <select name="ordenar" class="form-select">
                                     <option value="">-- Seleccionar --</option>
                                     <option value="fecha_asc">Fecha (más antigua)</option>
                                     <option value="fecha_desc">Fecha (más reciente)</option>
                                     <option value="cliente_asc">Cliente (A-Z)</option>
                                     <option value="cliente_desc">Cliente (Z-A)</option>
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

 </div>
 <div class="modal fade" id="modalAtajos" tabindex="-1" aria-labelledby="modalAtajosLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalAtajosLabel">Atajos de Teclado</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
             </div>
             <div class="modal-body">
                 <ul>
                     <li><strong>Ctrl + F:</strong> Buscar en el campo de búsqueda</li>
                     <li><strong>Ctrl + E:</strong> Exportar datos</li>
                     <li><strong>Ctrl + M:</strong> Abrir filtros avanzados</li>
                     <li><strong>Ctrl + L:</strong> Limpiar filtros</li>
                     <li><strong>Ctrl + Alt + N:</strong> Abrir formulario de nueva cita</li>
                     <li><strong>Ctrl + H:</strong> Mostrar ayuda de atajos</li>
                 </ul>
             </div>
         </div>
     </div>
 </div>

 @endsection