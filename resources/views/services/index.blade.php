@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Servicios</h2>

    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Nuevo Servicio</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('services.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, categoría o precio" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Disponible</th>
                <th>Duración (minutos)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->category }}</td>
                <td>Bs {{ number_format($service->price, 2) }}</td>
                <td>
                    @if($service->has_discount)
                        Bs {{ number_format($service->discount_price, 2) }}
                    @else
                        No
                    @endif
                </td>
                <td>{{ $service->has_available ? 'Sí' : 'No' }}</td>
                <td>{{ $service->duration_minutes }} minutos</td>
                <td>
                    <!-- Enlace para editar el servicio -->
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">Editar</a>

                    <!-- Formulario para eliminar el servicio -->
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este servicio?')">Eliminar</button>
                    </form>
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
