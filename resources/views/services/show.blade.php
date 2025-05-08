@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ $service->name }}</h2>

    <div class="row">
        <div class="col-md-6">
            <h5>Categoría:</h5>
            <p>{{ $service->category }}</p>

            <h5>Descripción:</h5>
            <p>{{ $service->description }}</p>

            <h5>Precio:</h5>
            <p>Bs {{ number_format($service->price, 2) }}</p>

            @if($service->has_discount)
            <h5>Precio con descuento:</h5>
            <p>Bs {{ number_format($service->discount_price, 2) }}</p>
            @endif

            <h5>Duración:</h5>
            <p>{{ $service->duration_minutes }} minutos</p>

            <h5>Tipo de atención:</h5>
            <p>{{ ucfirst($service->tipo_atencion) }}</p>

            <h5>Disponible:</h5>
            <p>{{ $service->has_available ? 'Sí' : 'No' }}</p>
        </div>

        <div class="col-md-6">
            <h5>Imágenes:</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($service->images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" width="120" height="120" style="object-fit: cover; border-radius: 8px;">
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>
</div>
@endsection
