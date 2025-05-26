@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4>Editar Producto o Insumo</h4>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('productos.update', $producto->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select">
                <option value="">-- Selecciona una categoría --</option>
                <option value="Cabello" {{ old('categoria', $producto->categoria)=='Cabello'?'selected':'' }}>Cabello</option>
                <option value="Uñas" {{ old('categoria', $producto->categoria)=='Uñas'?'selected':'' }}>Uñas</option>
                <option value="Piel" {{ old('categoria', $producto->categoria)=='Piel'?'selected':'' }}>Piel</option>
                <option value="Cejas" {{ old('categoria', $producto->categoria)=='Cejas'?'selected':'' }}>Cejas</option>
                <option value="Depilación" {{ old('categoria', $producto->categoria)=='Depilación'?'selected':'' }}>Depilación</option>
                <option value="Otros" {{ old('categoria', $producto->categoria)=='Otros'?'selected':'' }}>Otros</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo *</label>
            <select name="tipo" class="form-select" required>
                <option value="consumible" {{ old('tipo', $producto->tipo)=='consumible'?'selected':'' }}>Consumible</option>
                <option value="equipo" {{ old('tipo', $producto->tipo)=='equipo'?'selected':'' }}>Equipo/Material</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock *</label>
            <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', $producto->stock) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock mínimo</label>
            <input type="number" name="stock_minimo" class="form-control" min="0" value="{{ old('stock_minimo', $producto->stock_minimo) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <input type="text" name="unidad" class="form-control" placeholder="unidad, set, ml, etc." value="{{ old('unidad', $producto->unidad) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>
                <div class="mb-3">
            <label class="form-label">Sucursal *</label>
            <select name="sucursal_id" class="form-select" required>
                <option value="">-- Selecciona una sucursal --</option>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}"
                        {{ old('sucursal_id', $producto->sucursal_id ?? '') == $sucursal->id ? 'selected' : '' }}>
                        {{ $sucursal->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
