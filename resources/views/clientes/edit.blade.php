@extends('layouts.ap')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Editar Cliente</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Izquierda -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>Nombre completo</strong></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $cliente->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label><strong>Email</strong></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label><strong>Teléfono</strong></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $cliente->phone) }}">
                        </div>
                    </div>

                    <!-- Derecha: Foto de perfil -->
                    <div class="col-md-4">
                        <div class="card border border-secondary shadow-sm mb-2">
                            <div class="card-body text-center">
                                <label class="font-weight-bold mb-2">Foto de perfil</label>
                                <img id="preview" 
                                     src="{{ $cliente->photo_url ? asset('storage/' . $cliente->photo_url) : 'https://via.placeholder.com/180x180' }}" 
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

                <div class="form-group">
    <label><strong>Total de citas</strong></label>
    <p class="form-control-plaintext">{{ $cliente->total_citas }}</p>
</div>


                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" name="status" value="1" {{ $cliente->status ? 'checked' : '' }}>
                    <label class="form-check-label"><strong>Activo</strong></label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5 me-2">Actualizar Cliente</button>
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
        reader.onload = function() {
            const output = document.getElementById('preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
