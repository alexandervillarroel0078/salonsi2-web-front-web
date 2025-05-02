@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Promociones</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <a href="{{ route('promotions.create') }}" class="btn btn-primary mb-3">Crear Nueva Promoción</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Descuento (%)</th>
                <th>Fechas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion->name }}</td>
                <td>{{ $promotion->description }}</td>
                <td>{{ $promotion->discount_percentage }}%</td>
                <td>{{ $promotion->start_date }} - {{ $promotion->end_date }}</td>
                <td>
                    <a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta promoción?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
