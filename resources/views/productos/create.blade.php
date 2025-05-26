@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4>Registrar Nuevo Producto o Insumo</h4>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('productos.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select">
                <option value="">-- Selecciona una categoría --</option>
                <option value="Cabello" {{ old('categoria')=='Cabello'?'selected':'' }}>Cabello</option>
                <option value="Uñas" {{ old('categoria')=='Uñas'?'selected':'' }}>Uñas</option>
                <option value="Piel" {{ old('categoria')=='Piel'?'selected':'' }}>Piel</option>
                <option value="Cejas" {{ old('categoria')=='Cejas'?'selected':'' }}>Cejas</option>
                <option value="Depilación" {{ old('categoria')=='Depilación'?'selected':'' }}>Depilación</option>
                <option value="Otros" {{ old('categoria')=='Otros'?'selected':'' }}>Otros</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo *</label>
            <select name="tipo" class="form-select" required>
                <option value="consumible" {{ old('tipo')=='consumible'?'selected':'' }}>Consumible</option>
                <option value="equipo" {{ old('tipo')=='equipo'?'selected':'' }}>Equipo/Material</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock inicial *</label>
            <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', 0) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock mínimo</label>
            <input type="number" name="stock_minimo" class="form-control" min="0" value="{{ old('stock_minimo', 0) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <input type="text" name="unidad" class="form-control" placeholder="unidad, set, ml, etc." value="{{ old('unidad') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Sucursal *</label>
            <select name="sucursal_id" class="form-select" required>
                <option value="">-- Selecciona una sucursal --</option>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}"
                        {{ old('sucursal_id') == $sucursal->id ? 'selected' : '' }}>
                        {{ $sucursal->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion') }}</textarea>
        </div>


        <button type="submit" class="btn btn-success">Guardar Producto</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
