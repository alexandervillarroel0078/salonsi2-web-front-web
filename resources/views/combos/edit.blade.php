@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Combo</h2>

    <form method="POST" action="{{ route('combos.update', $combo->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre del Combo</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $combo->name) }}">
        </div>

        <div class="form-group">
            <label>Precio</label>
            <input type="number" name="price" class="form-control" required value="{{ old('price', $combo->price) }}">
        </div>

        <div class="form-group">
            <label>Precio con Descuento</label>
            <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price', $combo->discount_price) }}">
        </div>

        <div class="form-group">
            <label>¿Tiene Descuento?</label>
            <input type="checkbox" name="has_discount" value="1" {{ old('has_discount', $combo->has_discount) ? 'checked' : '' }}>
        </div>

        <div class="form-group">
            <label>Servicios</label>
            <select name="services[]" class="form-control" multiple>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ in_array($service->id, $combo->services->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar Combo</button>
    </form>
</div>
@endsection
