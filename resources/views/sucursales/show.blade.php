@extends('layouts.ap')
@section('content')
<div class="container mt-4">
    <h4>Sucursal: {{ $sucursal->nombre }}</h4>
    <p><strong>Dirección:</strong> {{ $sucursal->direccion }}</p>
    <p><strong>Teléfono:</strong> {{ $sucursal->telefono }}</p>
    <a href="{{ route('inventario.sucursal', $sucursal) }}" class="btn btn-primary">Ver Inventario Actual</a>
    <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
