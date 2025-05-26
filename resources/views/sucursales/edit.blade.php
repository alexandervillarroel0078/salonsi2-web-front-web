@extends('layouts.ap')
@section('content')
<div class="container mt-4">
    <h4>{{ isset($sucursal) ? 'Editar Sucursal' : 'Registrar Nueva Sucursal' }}</h4>
    @if($errors->any())
        <div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ isset($sucursal) ? route('sucursales.update', $sucursal) : route('sucursales.store') }}" method="POST">
        @csrf
        @if(isset($sucursal)) @method('PUT') @endif
        <div class="mb-3">
            <label>Nombre *</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $sucursal->nombre ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $sucursal->direccion ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $sucursal->telefono ?? '') }}">
        </div>
        <button type="submit" class="btn btn-success">{{ isset($sucursal) ? 'Actualizar' : 'Registrar' }}</button>
        <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
