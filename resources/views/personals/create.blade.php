@extends('layouts.ap')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registrar Nuevo Personal</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('personals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 🟦 Grupo 1: dos columnas -->
                <div class="row">
                    <!-- Izquierda -->
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
                    </div>

                    <!-- Derecha: Foto de perfil -->
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
                            <input type="file" name="photo_file" class="form-control-file" onchange="previewImage(event)">

                        </div>
                    </div>
                </div>

                <hr>

                <!-- ✅ Selección de cargo real desde tabla cargo_empleados -->
                <div class="form-group">
                    <label><strong>Cargo</strong></label>
                    <select name="cargo_empleado_id" class="form-control" required>
                        <option value="">-- Selecciona un cargo --</option>
                        @foreach($cargos as $cargo)
                        <option value="{{ $cargo->id }}">{{ $cargo->cargo }}</option>
                        @endforeach
                    </select>
                </div>


                <!-- Multi-select de especialidades -->
                <div class="form-group">
                    <label><strong>Especialidades del personal (puede seleccionar varias)</strong></label>
                    <select id="servicioSelect" class="form-control">
                        @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="agregarServicio()">Agregar</button>
                </div>

                <!-- Contenedor visual para los servicios seleccionados -->
                <div class="form-group mt-3">
                    <label><strong>Servicios seleccionados</strong></label>

                    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 12px; min-height: 50px; background-color: #f8f9fa;">
                        <div id="serviciosSeleccionados" class="d-flex flex-wrap gap-2">
                            @foreach($personal->specialties ?? [] as $sp)
                            @php
                            $service = $services->firstWhere('id', $sp);
                            @endphp
                            @if($service)
                            <div class="badge bg-secondary d-flex align-items-center">
                                {{ $service->name }}
                                <input type="hidden" name="specialties[]" value="{{ $sp }}">
                                <button type="button" class="btn-close btn-close-white ms-2" onclick="this.parentElement.remove()" style="margin-left: 8px;"></button>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label><strong>Fecha y hora de ingreso</strong></label>
                    <input type="datetime-local" name="fecha_ingreso" class="form-control"
                        value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                        readonly>
                </div>



                <div class="form-group">
                    <label><strong>Descripción / Bio</strong></label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Ej. Más de 5 años de experiencia..."></textarea>
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

                <div class="text-center">
    <a href="{{ route('personals.index') }}" class="btn btn-secondary px-5 me-2">Cancelar</a>
    <button type="submit" class="btn btn-success px-5">Guardar Personal</button>
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

<!-- JS: Manejo de especialidades -->
<script>
    const especialidades = new Map();

    function agregarEspecialidad() {
        const select = document.getElementById('servicioSelect');
        const valor = select.value;
        const texto = select.options[select.selectedIndex].text;

        if (!especialidades.has(valor)) {
            especialidades.set(valor, texto);
            renderizarEspecialidades();
        }
    }

    function eliminarEspecialidad(valor) {
        especialidades.delete(valor);
        renderizarEspecialidades();
    }

    function renderizarEspecialidades() {
        const container = document.getElementById('listaEspecialidades');
        const hidden = document.getElementById('hiddenSpecialties');
        container.innerHTML = '';
        hidden.innerHTML = '';

        especialidades.forEach((texto, valor) => {
            const chip = document.createElement('span');
            chip.className = 'badge bg-secondary text-white px-3 py-2 me-2 mb-2 d-inline-flex align-items-center rounded-pill';

            chip.innerHTML = `
            <span class="me-2">${texto}</span>
            <span style="cursor:pointer;" onclick="eliminarEspecialidad('${valor}')">&times;</span>
        `;

            container.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'specialties[]';
            input.value = valor;
            hidden.appendChild(input);
        });
    }
</script>
<script>
    function agregarServicio() {
        const select = document.getElementById('servicioSelect');
        const selectedId = select.value;
        const selectedText = select.options[select.selectedIndex].text;

        // Verificar que no se repita
        const yaExiste = [...document.getElementsByName('specialties[]')]
            .some(input => input.value === selectedId);

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