<!-- Agrega esto en tu layout o directamente en edit.blade.php -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4>Editar Combo</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('combos.update', $combo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $combo->name) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $combo->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" name="price" id="price" step="0.01" class="form-control" required value="{{ old('price', $combo->price) }}">
        </div>

        <div class="mb-3">
            <label for="discount_price" class="form-label">Precio con Descuento (opcional)</label>
            <input type="number" name="discount_price" id="discount_price" step="0.01" class="form-control" value="{{ old('discount_price', $combo->discount_price) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Servicios Asociados</label>
            <select name="services[]" id="services" class="form-select" multiple required>
                @foreach($services as $service)
                <option value="{{ $service->id }}" {{ in_array($service->id, $combo->services->pluck('id')->toArray()) ? 'selected' : '' }}>
                    {{ $service->name }}
                </option>
                @endforeach
            </select>
            <small class="text-muted">Selecciona uno o varios servicios.</small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="active" id="active" class="form-check-input" {{ old('active', $combo->active) ? 'checked' : '' }}>
            <label for="active" class="form-check-label">¿Activo?</label>
        </div>

        <button type="submit" class="btn btn-success">Actualizar Combo</button>
        <a href="{{ route('combos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

<script>
    $(document).ready(function() {
        $('#services').select2({
            placeholder: "Selecciona los servicios",
            width: '100%'
        });
    });
</script>
