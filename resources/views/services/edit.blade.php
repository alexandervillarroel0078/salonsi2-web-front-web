@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Servicio</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="description" class="form-control">{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $service->category) }}">
        </div>

        <div class="form-group">
            <label>Precio</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $service->price) }}" required>
        </div>

        <div class="form-group">
            <label>Precio con Descuento</label>
            <input type="number" name="discount_price" class="form-control" step="0.01" value="{{ old('discount_price', $service->discount_price) }}">
        </div>

        <div class="form-group">
            <label>Duración (en minutos)</label>
            <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $service->duration_minutes) }}">
        </div>

        <div class="form-group">
            <label>Especialista</label>
            <select name="specialist_id" class="form-control">
                <option value="">Seleccionar especialista</option>
                @foreach ($specialists as $specialist)
                    <option value="{{ $specialist->id }}" {{ old('specialist_id', $service->specialist_id) == $specialist->id ? 'selected' : '' }}>
                        {{ $specialist->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>¿Tiene Descuento?</label>
            <input type="checkbox" name="has_discount" value="1" {{ old('has_discount', $service->has_discount) ? 'checked' : '' }}>
        </div>

        <div class="form-group">
            <label>¿Está Disponible?</label>
            <input type="checkbox" name="has_available" value="1" {{ old('has_available', $service->has_available) ? 'checked' : '' }}>
        </div>

        <div class="form-group">
            <label>Imagen</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Actualizar Servicio</button>
    </form>
</div>
@endsection
