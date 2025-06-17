@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Clientes</h2>

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @can('crear clientes')
    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Nuevo Cliente</a>
    @endcan

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">

                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar por nombre o email</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por nombre o email" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="format" class="form-label">Formato</label>
                    <select name="format" id="format" class="form-select">
                        <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="html" {{ request('format') == 'html' ? 'selected' : '' }}>HTML</option>
                    </select>
                </div>

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

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary" formaction="{{ route('clientes.index') }}">Filtrar</button>
                </div>

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
        <tbody id="tbody-clientes">
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>
                   @if($cliente->photo_url)
    <img src="{{ $cliente->photo_url }}" alt="Foto" width="80" height="80">
@else
    <span>Sin foto</span>
@endif

                </td>
                <td>{{ $cliente->name }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->phone }}</td>
                <td>{{ $cliente->agendas_count ?? 0 }}</td>
                <td>
                    @if($cliente->status)
                    <span class="badge bg-success">Activo</span>
                    @else
                    <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
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
            @endforeach
        </tbody>
    </table>

   <div class="d-flex justify-content-center" id="pagination-container">
    {{ $clientes->appends(['search' => request('search')])->links() }}
</div>

</div>
@endsection
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();
            console.log('Buscando:', query);
            $.ajax({
                url: "{{ route('clientes.searchAjax') }}",
                method: 'GET',
                data: {
                    query: query
                },
         success: function(data) {
    $('#tbody-clientes').html(data);
    if ($('#search').val().trim() !== '') {
        $('#pagination-container').hide();
    } else {
        $('#pagination-container').show();
    }
}

,

                error: function() {
                    console.error('Error al hacer búsqueda AJAX');
                }
            });
        });
    });
</script>
@endpush