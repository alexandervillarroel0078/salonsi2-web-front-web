@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Promoción</h2>

    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $promotion->name) }}">
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="description" class="form-control" required>{{ old('description', $promotion->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Descuento (%)</label>
            <input type="number" name="discount_percentage" class="form-control" required value="{{ old('discount_percentage', $promotion->discount_percentage) }}" min="0" max="100">
        </div>

        <div class="form-group">
            <label>Fecha de Inicio</label>
            <input type="date" name="start_date" class="form-control" required value="{{ old('start_date', $promotion->start_date) }}">
        </div>

        <div class="form-group">
            <label>Fecha de Fin</label>
            <input type="date" name="end_date" class="form-control" required value="{{ old('end_date', $promotion->end_date) }}">
        </div>

        <button type="submit" class="btn btn-success mt-3">Actualizar</button>
    </form>
</div>
@endsection
