<!-- Select2 (solo para especialidades múltiples) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@extends('layouts.ap')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Editar Personal</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('personals.update', $personal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>Nombre completo</strong></label>
                            <input type="text" name="name" class="form-control" required value="{{ $personal->name }}">
                        </div>
                        <div class="form-group">
                            <label><strong>Email</strong></label>
                            <input type="email" name="email" class="form-control" required value="{{ $personal->email }}">
                        </div>
                        <div class="form-group">
                            <label><strong>Teléfono</strong></label>
                            <input type="text" name="phone" class="form-control" value="{{ $personal->phone }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border border-secondary shadow-sm mb-2">
                            <div class="card-body text-center">
                                <label class="font-weight-bold mb-2">Foto de perfil</label>
                                <img id="preview" src="{{ $personal->photo_url ?? 'https://via.placeholder.com/180x180' }}"
                                    class="rounded-circle img-thumbnail"
                                    style="width: 180px; height: 180px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="file" name="photo_url" class="form-control-file" onchange="previewImage(event)">
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group mb-4">
                    <label><strong>Especialidades del personal</strong></label>
                    <select name="specialties[]" id="specialties" class="form-select" multiple required>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $personal->services->contains($service->id) ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Puedes seleccionar una o varias especialidades.</small>
                </div>

                <div class="form-group">
                    <label><strong>Fecha de ingreso</strong></label>
                    <input type="date" class="form-control" value="{{ $personal->created_at->format('Y-m-d') }}" readonly>
                </div>

                <div class="form-group">
                    <label><strong>Rol asignado</strong></label>
                    <input type="text" class="form-control" value="{{ $personal->role_name ?? 'No asignado' }}" readonly>
                </div>

                <div class="form-group">
                    <label><strong>Descripción / Bio</strong></label>
                    <textarea name="description" class="form-control" rows="3">{{ $personal->description }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Instagram</strong></label>
                        <input type="url" name="instagram" class="form-control" value="{{ $personal->instagram }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Facebook</strong></label>
                        <input type="url" name="facebook" class="form-control" value="{{ $personal->facebook }}">
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" class="form-check-input" name="status" value="1" {{ $personal->status ? 'checked' : '' }}>
                    <label class="form-check-label"><strong>Activo</strong></label>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('personals.index') }}" class="btn btn-secondary px-5 me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success px-5">Actualizar Personal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    $(document).ready(function() {
        $('#specialties').select2({
            placeholder: "Selecciona las especialidades",
            width: '100%'
        });
    });

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
