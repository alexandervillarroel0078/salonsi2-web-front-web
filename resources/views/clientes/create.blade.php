@extends('layouts.ap')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registrar Nuevo Cliente</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Datos personales -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>Nombre completo</strong></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><strong>Email</strong></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><strong>Teléfono</strong></label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Dirección</strong></label>
                            <input type="text" name="address" class="form-control">
                        </div>
                    </div>

                    <!-- Foto de perfil -->
                    <div class="col-md-4">
                        <div class="card border border-secondary shadow-sm mb-2">
                            <div class="card-body text-center">
                                <label class="font-weight-bold mb-2">Foto de perfil</label>
                                <img id="preview" src="https://via.placeholder.com/180x180"
                                     class="rounded-circle img-thumbnail"
                                     style="width: 180px; height: 180px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="file" name="photo" class="form-control-file" onchange="previewImage(event)">
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Estado -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="status" value="1" checked>
                    <label class="form-check-label"><strong>Activo</strong></label>
                </div>

                <div class="text-center">
    <button type="submit" class="btn btn-success px-5 me-2">Guardar Cliente</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary px-4">Cancelar</a>
</div>

            </form>
        </div>
    </div>
</div>

<!-- JS: Previsualizar imagen -->
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
