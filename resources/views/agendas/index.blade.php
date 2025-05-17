 @extends('layouts.ap')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#search').on('keyup', function () {
        let query = $(this).val();
        $.ajax({
            url: "{{ route('agendas.searchAjax') }}",
            method: 'GET',
            data: { query: query },
            success: function (data) {
                $('tbody').html(data);
            },
            error: function () {
                console.error('Error al hacer búsqueda AJAX');
            }
        });
    });
});
</script>

 @section('content')
 <div class="container mt-4">
     <h4 class="mb-4">Agenda de Citas</h4>

     @can('crear citas')
     <a href="{{ route('agendas.create') }}" class="btn btn-success mb-3">+ Nueva Cita</a>
     @endcan

     <!-- Buscador por fecha 
     <form action="{{ route('agendas.index') }}" method="GET" class="mb-3">
         <div class="input-group">
             <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-control" placeholder="Buscar por fecha">
             <button type="submit" class="btn btn-primary">Buscar</button>
         </div>
     </form>--> <!-- -->

     {{-- Contenedor de Filtros y Exportación --}}
     <div class="card mb-4 shadow-sm">
         <div class="card-body">
             <form method="GET" class="row g-2 align-items-end">

                 {{-- Buscar por fecha, cliente o personal --}}
                 <div class="col-md-3">
                     <label for="search" class="form-label">Buscar por fecha, cliente o personal</label>
                     <div class="input-group">
                         <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por fecha, cliente o personal" value="{{ request('search') }}">
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
                 {{-- Filtro por fecha exacta --}}
                 <div class="col-md-2">
                     <label for="fecha" class="form-label">Fecha</label>
                     <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
                 </div>

                 <!--    {{-- Botón Filtrar --}}
                 <div class="col-md-2 d-grid">
                     <label class="form-label invisible">Filtrar</label>
                     <button type="submit" class="btn btn-primary">Filtrar</button>
                 </div>-->
                 {{-- Selección de columnas personalizadas --}}
                 <div class="col-md-3">
                     <label for="columns" class="form-label">Seleccionar columnas</label>
                     <div class="form-check">
                         <input type="checkbox" name="columns[]" class="form-check-input" id="col_id" value="id" {{ in_array('id', request('columns', [])) ? 'checked' : '' }}>
                         <label class="form-check-label" for="col_id">ID</label>
                     </div>
                     <div class="form-check">
                         <input type="checkbox" name="columns[]" class="form-check-input" id="col_cliente" value="cliente_id" {{ in_array('cliente_id', request('columns', [])) ? 'checked' : '' }}>
                         <label class="form-check-label" for="col_cliente">Cliente</label>
                     </div>
                     <div class="form-check">
                         <input type="checkbox" name="columns[]" class="form-check-input" id="col_fecha" value="fecha" {{ in_array('fecha', request('columns', [])) ? 'checked' : '' }}>
                         <label class="form-check-label" for="col_fecha">Fecha</label>
                     </div>
                     <div class="form-check">
                         <input type="checkbox" name="columns[]" class="form-check-input" id="col_personal" value="personal_id" {{ in_array('personal_id', request('columns', [])) ? 'checked' : '' }}>
                         <label class="form-check-label" for="col_personal">Personal</label>
                     </div>
                     <div class="form-check">
                         <input type="checkbox" name="columns[]" class="form-check-input" id="col_estado" value="estado" {{ in_array('estado', request('columns', [])) ? 'checked' : '' }}>
                         <label class="form-check-label" for="col_estado">Estado</label>
                     </div>
                 </div>

                 {{-- Botón Filtrar --}}
                 <div class="col-md-2 d-grid">
                     <button type="submit" class="btn btn-primary" formaction="{{ route('agendas.index') }}">Filtrar</button>
                 </div>

                 {{-- Botón Exportar --}}
                 <div class="col-md-2 d-grid">
                     <button type="submit" class="btn btn-success" formaction="{{ route('agendas.export') }}" formtarget="_blank">Exportar</button>
                 </div>

             </form>
         </div>
     </div>


     <!-- Tabla de citas -->
     <div class="card shadow-sm">
         <div class="card-body p-0">
             <table class="table table-hover mb-0">
                 <thead class="table-dark">
                     <tr>
                         <th>ID</th>
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
                         <td>{{ $agenda->fecha }}</td>
                         <td>{{ $agenda->hora }}</td>
                         <td>{{ $agenda->cliente->name ?? '-' }}</td>

                         <td>{{ $agenda->personal->name ?? '-' }}</td>

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
 </div>
 @endsection