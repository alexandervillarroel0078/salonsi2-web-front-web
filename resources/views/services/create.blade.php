@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Registrar Nuevo Servicio</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label><strong>Categoría</strong></label>
            <select name="category" class="form-control" required>
                <option value="">-- Selecciona una categoría --</option>
                <option value="Cabello">Cabello</option>
                <option value="Uñas">Uñas</option>
                <option value="Piel">Piel</option>
                <option value="Cejas">Cejas</option>
                <option value="Depilación">Depilación</option>
                <!-- Puedes agregar más -->
            </select>
        </div>

        <div class="mb-3">
            <label><strong>Nombre del Servicio</strong></label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label><strong>Descripción</strong></label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label><strong>Duración estimada (minutos)</strong></label>
            <input type="number" name="duration_minutes" class="form-control" required min="5">
        </div>

        <div class="mb-3">
            <label><strong>Precio</strong></label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label><strong>Imágenes del Servicio (máximo 5)</strong></label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple onchange="previewImages(this)">
            <small class="text-muted">Puedes subir hasta 5 imágenes.</small>

            <!-- Vista previa de imágenes recién seleccionadas -->
            <!-- Vista previa de imágenes seleccionadas -->
            <div id="previewContainer" style="
    border: 2px dashed #ccc;
    border-radius: 10px;
    padding: 10px;
    margin-top: 10px;
    min-height: 120px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    background-color: #f9f9f9;
"></div>

            <!-- Contenedor de imágenes ya subidas (en edit será útil) -->
            <div id="existingImages" class="mt-3 d-flex flex-wrap gap-2" style="display: none;">
                {{-- Aquí irán miniaturas de imágenes ya almacenadas si fuera necesario --}}
                {{-- En edit puedes recorrer con @foreach($service->images as $img) ... --}}
            </div>
        </div>

        <div class="mb-3">
    <label><strong>Tipo de Atención</strong></label>
    <select name="tipo_atencion" class="form-control" required>
        <option value="">-- Selecciona el tipo de atención --</option>
        <option value="salon">En salón</option>
        <option value="domicilio">A domicilio</option>
    </select>
</div>

        <div class="mb-3">
            <label><strong>¿Disponible para agendar?</strong></label>
            <select name="has_available" class="form-control" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="text-center">
    <button type="submit" class="btn btn-success">Guardar Servicio</button>
    <a href="{{ route('services.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
</div>

    </form>
</div>

{{-- Script para previsualización de imágenes --}}
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
                img.classList.add('rounded', 'me-2', 'mb-2');
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