@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Personal</h2>

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form method="GET" action="{{ route('personals.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o email" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>

    <a href="{{ route('personals.create') }}" class="btn btn-primary mb-3">Nuevo Personal</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($personals as $personal)
            <tr>
                <td>{{ $personal->id }}</td>
                <td>{{ $personal->name }}</td>
                <td>{{ $personal->email }}</td>
                <td>{{ $personal->phone }}</td>
                <td>{{ $personal->status ? 'Activo' : 'Inactivo' }}</td>
                <td><img src="{{ $personal->photo_url }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover;"></td>
                <td>
                    <a href="{{ route('personals.edit', $personal->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('personals.destroy', $personal->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este personal?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No hay personal registrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $personals->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection
