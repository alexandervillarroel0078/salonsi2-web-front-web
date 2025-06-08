@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Personal</h2>

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif


    @can('crear empleados')
    <a href="{{ route('personals.create') }}" class="btn btn-primary mb-3">Nuevo Personal</a>
    @endcan


    <!-- {{-- Contenedor de Filtros y Exportación --}}
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
                </div>

                {{-- Botón Filtrar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary" formaction="{{ route('personals.index') }}">Filtrar</button>
                </div>

                {{-- Botón Exportar --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success" formaction="{{ route('personals.export') }}" formtarget="_blank">Exportar</button>
                </div>

            </form>
        </div>
    </div> -->



    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th>Estado</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody-personal">
                @foreach($personals as $personal)
                <tr>
                    <td>{{ $personal->id }}</td>
                    <td>{{ $personal->name }}</td>
                    <td>{{ $personal->email }}</td>
                    <td>{{ $personal->phone }}</td>
                    <td>{{ $personal->cargo->cargo ?? 'Sin cargo' }}</td>
                    <td>
                        @if($personal->status)
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <img src="{{ $personal->photo_url ?? asset('images/default-profile.png') }}" class="rounded-circle" style="width:50px; height:50px;">
                    </td>
                    <td>
                        <a href="{{ route('personals.show', $personal->id) }}" class="btn btn-sm btn-info">Ver</a>
                        @can('editar empleados')
                        <a href="{{ route('personals.edit', $personal->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        @endcan
                        @can('eliminar empleados')
                        <form action="{{ route('personals.destroy', $personal->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este personal?')">Eliminar</button>
                        </form>
                        @endcan
                    </td>

                </tr>
                @endforeach
            </tbody>


        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $personals->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('personals.searchAjax') }}",
                method: 'GET',
                data: {
                    query: query
                },
                success: function(data) {
                    $('#tbody-personal').html(data);
                },
                error: function() {
                    console.error('Error al cargar resultados');
                }
            });
        });
    });
</script>
@endpush