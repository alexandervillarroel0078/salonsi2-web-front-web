@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Editar Servicio</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label><strong>Categoría</strong></label>
            <select name="category" class="form-control" required>
                <option value="">-- Selecciona una categoría --</option>
                @foreach($categorias as $cat)
                <option value="{{ $cat }}" {{ $service->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label><strong>Nombre del Servicio</strong></label>
            <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
        </div>

        <div class="mb-3">
            <label><strong>Descripción</strong></label>
            <textarea name="description" class="form-control" rows="3" required>{{ $service->description }}</textarea>
        </div>

        <div class="mb-3">
            <label><strong>Duración estimada (minutos)</strong></label>
            <input type="number" name="duration_minutes" class="form-control" value="{{ $service->duration_minutes }}" required min="5">
        </div>

        <div class="mb-3">
            <label><strong>Precio</strong></label>
            <input type="number" name="price" class="form-control" step="0.01" value="{{ $service->price }}" required>
        </div>

        <div class="mb-3">
            <label><strong>Imágenes del Servicio (máximo 5)</strong></label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple onchange="previewImages(this)">
            <small class="text-muted">Puedes subir hasta 5 imágenes.</small>

            {{-- Vista previa nuevas --}}
            <div id="previewContainer" class="mt-2 p-2 d-flex flex-wrap gap-2 border rounded bg-light" style="min-height: 120px;"></div>

            {{-- Imágenes existentes --}}
            <div class="mt-3 d-flex flex-wrap gap-2">
                @foreach($service->images ?? [] as $img)
                <div>
                    <img src="{{ asset('storage/' . $img->path) }}" alt="Imagen" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label><strong>Tipo de Atención</strong></label>
            <select name="tipo_atencion" class="form-control" required>
                <option value="">-- Selecciona el tipo de atención --</option>
                <option value="salon" {{ $service->tipo_atencion == 'salon' ? 'selected' : '' }}>En salón</option>
                <option value="domicilio" {{ $service->tipo_atencion == 'domicilio' ? 'selected' : '' }}>A domicilio</option>
            </select>
        </div>

        <div class="mb-3">
            <label><strong>¿Disponible para agendar?</strong></label>
            <select name="has_available" class="form-control" required>
                <option value="1" {{ $service->has_available ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ !$service->has_available ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="text-center d-flex justify-content-center gap-3">
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
        </div>

    </form>
</div>

{{-- Script para previsualización --}}
<script>
    function previewImages(input) {
        const container = document.getElementById('previewContainer');
        container.innerHTML = '';

        const files = input.files;
        if (files.length > 5) {
            alert('Solo puedes subir hasta 5 imágenes.');
            input.value = '';
            return;
        }

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded');
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endsection