@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Promociones</h2>

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @can('crear promociones')
    <a href="{{ route('promotions.create') }}" class="btn btn-primary mb-3">Crear Nueva Promoción</a>
    @endcan

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Descuento (%)</th>
                <th>Fechas</th>
                <th>Estado</th>
                <th>Servicios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion->id }}</td>
                <td>{{ $promotion->name }}</td>
                <td>{{ $promotion->description }}</td>
                <td>{{ $promotion->discount_percentage }}%</td>
                <td>{{ $promotion->start_date }} - {{ $promotion->end_date }}</td>
                <td>
                    @if($promotion->active)
                    <span class="badge bg-success">Activa</span>
                    @else
                    <span class="badge bg-danger">Inactiva</span>
                    @endif
                </td>
                <td>
                    @foreach($promotion->services as $service)
                    <span class="badge bg-secondary">{{ $service->name }}</span>
                    @endforeach
                </td>
                <td>
                    @can('editar promociones')
                    <a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    @endcan

                    @can('eliminar promociones')
                    <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta promoción?')">Eliminar</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection