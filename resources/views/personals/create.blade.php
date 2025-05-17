@extends('layouts.ap')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Registrar Nuevo Personal</h4>
            <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#ayudaFormulario">
                <i class="fas fa-question-circle"></i> Ayuda
            </button>
        </div>

        <div class="card-body">
            <form action="{{ route('personals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <fieldset class="border p-3 mb-3">
                    <legend class="w-auto px-2 text-primary">Datos personales</legend>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label><strong>Nombre completo <span class="text-danger">*</span></strong>
                                    <i class="fas fa-question-circle text-info" data-bs-toggle="tooltip" title="Nombre y apellido del personal."></i>
                                </label>
                                <input type="text" name="name" class="form-control" required>
                                @error('name')<small class="text-danger">* {{ $message }}</small>@enderror
                            </div>
                            <div class="form-group mb-3">
                                <label><strong>Email <span class="text-danger">*</span></strong></label>
                                <input type="email" name="email" class="form-control" required>
                                @error('email')<small class="text-danger">* {{ $message }}</small>@enderror
                            </div>
                            <div class="form-group mb-3">
                                <label><strong>Teléfono</strong></label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border border-secondary shadow-sm mb-2">
                                <div class="card-body text-center">
                                    <label class="font-weight-bold mb-2">Foto de perfil</label>
                                    <img id="preview" src="https://via.placeholder.com/180x180" class="rounded-circle img-thumbnail" style="width: 180px; height: 180px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" name="photo_file" class="form-control-file" onchange="previewImage(event)">
                                <small class="text-muted">Formatos: JPG, PNG. Máx 2MB.</small>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-3 mb-3">
                    <legend class="w-auto px-2 text-primary">Asignación</legend>
                    <div class="form-group mb-3">
                        <label><strong>Cargo <span class="text-danger">*</span></strong></label>
                        <select name="cargo_empleado_id" class="form-control" required>
                            <option value="">-- Selecciona un cargo --</option>
                            @foreach($cargos as $cargo)
                            <option value="{{ $cargo->id }}">{{ $cargo->cargo }}</option>
                            @endforeach
                        </select>
                        @error('cargo_empleado_id')<small class="text-danger">* {{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <label><strong>Especialidades del personal</strong></label>
                        <select id="servicioSelect" class="form-control">
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="agregarServicio()">Agregar</button>
                    </div>

                    <div class="form-group mt-3">
                        <label><strong>Servicios seleccionados</strong></label>
                        <div style="border: 1px solid #ccc; border-radius: 8px; padding: 12px; min-height: 50px; background-color: #f8f9fa;">
                            <div id="serviciosSeleccionados" class="d-flex flex-wrap gap-2">
                                @foreach($personal->specialties ?? [] as $sp)
                                @php $service = $services->firstWhere('id', $sp); @endphp
                                @if($service)
                                <div class="badge bg-secondary d-flex align-items-center">
                                    {{ $service->name }}
                                    <input type="hidden" name="specialties[]" value="{{ $sp }}">
                                    <button type="button" class="btn-close btn-close-white ms-2" onclick="this.parentElement.remove()"></button>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-3 mb-3">
                    <legend class="w-auto px-2 text-primary">Redes y Descripción</legend>
                    <div class="form-group">
                        <label><strong>Fecha y hora de ingreso</strong></label>
                        <input type="datetime-local" name="fecha_ingreso" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>Descripción / Bio</strong></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Ej. Más de 5 años de experiencia..."></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><strong>Instagram</strong></label>
                            <input type="url" name="instagram" class="form-control" placeholder="https://instagram.com/usuario">
                        </div>
                        <div class="form-group col-md-6">
                            <label><strong>Facebook</strong></label>
                            <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/usuario">
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" name="status" value="1" checked>
                        <label class="form-check-label"><strong>Activo</strong></label>
                    </div>
                </fieldset>

                <div class="text-center">
                    <a href="{{ route('personals.index') }}" class="btn btn-secondary px-5 me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success px-5">Guardar Personal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de ayuda -->
<div class="modal fade" id="ayudaFormulario" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Guía para llenar el formulario</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li><strong>Nombre:</strong> Nombre completo del personal.</li>
                    <li><strong>Email:</strong> Debe ser válido.</li>
                    <li><strong>Cargo:</strong> Cargo asignado según la estructura del salón.</li>
                    <li><strong>Especialidades:</strong> Servicios que está capacitado a realizar.</li>
                    <li><strong>Redes sociales:</strong> Opcional para fines promocionales.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para preview de imagen y especialidades -->
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function agregarServicio() {
        const select = document.getElementById('servicioSelect');
        const selectedId = select.value;
        const selectedText = select.options[select.selectedIndex].text;

        const yaExiste = [...document.getElementsByName('specialties[]')].some(input => input.value === selectedId);
        if (yaExiste) return;

        const contenedor = document.getElementById('serviciosSeleccionados');

        const div = document.createElement('div');
        div.className = 'badge bg-secondary position-relative me-2 mb-2';
        div.innerHTML = `
            ${selectedText}
            <input type="hidden" name="specialties[]" value="${selectedId}">
            <button type="button" class="btn-close btn-close-white ms-2" onclick="this.parentElement.remove()"></button>
        `;

        contenedor.appendChild(div);
    }
</script>
@endsection
