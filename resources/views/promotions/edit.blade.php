<!-- ✅ Agrega esto antes del layout -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4>Editar Promoción</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $promotion->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" required>{{ old('description', $promotion->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="discount_percentage" class="form-label">Descuento (%)</label>
            <input type="number" name="discount_percentage" class="form-control" min="1" max="100"
                value="{{ old('discount_percentage', $promotion->discount_percentage) }}" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de inicio</label>
            <input type="date" name="start_date" class="form-control"
                value="{{ old('start_date', $promotion->start_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de fin</label>
            <input type="date" name="end_date" class="form-control"
                value="{{ old('end_date', $promotion->end_date) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Servicios Asociados</label>
            <select name="services[]" id="services" class="form-select" multiple required>
                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                        {{ in_array($service->id, $promotion->services->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Selecciona uno o varios servicios.</small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="active" class="form-check-input" id="active"
                {{ old('active', $promotion->active) ? 'checked' : '' }}>
            <label class="form-check-label" for="active">¿Activa?</label>
        </div>

        <button type="submit" class="btn btn-success">Actualizar Promoción</button>
        <a href="{{ route('promotions.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

<!-- ✅ Activar Select2 -->
<script>
    $(document).ready(function () {
        $('#services').select2({
            placeholder: "Selecciona los servicios",
            width: '100%'
        });
    });
</script>
