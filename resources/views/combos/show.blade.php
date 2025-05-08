@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Detalle del Combo</h4>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $combo->name }}</h5>
            <p class="card-text"><strong>Descripción:</strong> {{ $combo->description }}</p>

            <p class="card-text">
                <strong>Precio:</strong> Bs. {{ number_format($combo->price, 2) }}
            </p>

            <p class="card-text">
                <strong>Precio con descuento:</strong>
                @if($combo->has_discount && $combo->discount_price)
                    <span class="text-success">Bs. {{ number_format($combo->discount_price, 2) }}</span>
                @else
                    <span class="text-muted">Sin descuento</span>
                @endif
            </p>

            <p class="card-text">
                <strong>Estado:</strong>
                @if($combo->active)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-danger">Inactivo</span>
                @endif
            </p>

            <p class="card-text">
                <strong>Servicios incluidos:</strong><br>
                @foreach($combo->services as $service)
                    <span class="badge bg-secondary">{{ $service->name }}</span>
                @endforeach
            </p>

            @if($combo->image_path)
                <div class="mt-3">
                    <strong>Imagen:</strong><br>
                    <img src="{{ $combo->image_path }}" alt="Imagen del combo" class="img-fluid rounded" style="max-width: 300px;">
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('combos.index') }}" class="btn btn-secondary mt-3">Volver a la lista</a>
</div>
@endsection
