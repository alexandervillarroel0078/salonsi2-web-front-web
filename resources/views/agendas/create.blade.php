@extends('layouts.ap')


@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Registrar Nueva Cita</h4>
    @if ($errors->has('general'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first('general') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('agendas.store') }}">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="col-md-6">
                    <label><strong>Cliente</strong></label>
                    @if(auth()->user()->cliente)
                    <input type="hidden" name="cliente_id" value="{{ auth()->user()->cliente->id }}">
                    <input type="text" class="form-control" value="{{ auth()->user()->cliente->name }}" readonly>
                    @else
                    <select name="cliente_id" class="form-control" required>
                        <option value="">-- Seleccionar Cliente --</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->name }}
                        </option>
                        @endforeach
                    </select>
                    @endif
                </div>

                <!-- 🟦 Servicios que solicita el cliente -->
                <div class="form-group">
                    <label><strong>Servicios solicitados</strong></label>
                    <div class="input-group">
                        <select id="servicioSelect" class="form-control">
                            @foreach ($servicios as $servicio)
                            <option
                                value="{{ $servicio->id }}"
                                data-duration="{{ $servicio->duration_minutes }}"
                                data-price="{{ $servicio->has_discount ? $servicio->discount_price : $servicio->price }}"
                                data-image="{{ $servicio->image_path }}"
                                data-description="{{ e($servicio->description) }}"
                                {{--  ⬇️  Nota: comillas simples afuera, @json adentro  --}}
                                data-personal='@json($servicio->personal->map(fn($p) => ["id"=>$p->id,"name"=>$p->name]))'>
                                {{ $servicio->name }}
                            </option>
                            @endforeach
                        </select>


                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="agregarServicio()">Agregar</button>
                        </div>
                    </div>
                    <small class="form-text text-muted">Seleccione servicios y se agregarán a la lista.</small>
                </div>

                <div class="mt-3">
                    <label><strong>Resumen de servicios</strong></label>
                    <table class="table table-bordered" id="tablaServicios">

                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Servicio</th>
                                <th>Duración</th>
                                <th>Precio</th>
                                <th>Personal asignado</th>
                                <th>Cantidad</th>
                                <th>Quitar</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>

                <!-- Inputs ocultos -->
                <div id="hiddenServicios"></div>

                <!-- Contenedor -->
                <div class="container border p-3 mt-4 rounded shadow-sm">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Fecha</strong></label>
                            <input type="date" name="fecha" class="form-control" required min="{{ date('Y-m-d') }}" value="{{ old('fecha') }}">
                        </div>
                        <div class="col-md-6">
                            <label><strong>Hora</strong></label>
                            <select name="hora" class="form-control" required>
                                @for ($h = 8; $h <= 20; $h++)
                                    @php
                                    $hora=sprintf('%02d:00', $h);
                                    @endphp
                                    <option value="{{ $hora }}">{{ $hora }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label><strong>Duración total</strong></label>
                            <input type="text" id="duracionTotalVisual" class="form-control" readonly>
                            <input type="hidden" name="duracion" id="duracionTotal">
                        </div>

                        <div class="col-md-6">
                            <label><strong>Precio total</strong></label>
                            <input type="text" name="precio_total" id="precioTotal" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><strong>Tipo de atención</strong></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_atencion" value="salon" id="atencionSalon" checked onchange="controlarDireccion()">
                            <label class="form-check-label" for="atencionSalon">En Salón</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_atencion" value="domicilio" id="atencionDomicilio" onchange="controlarDireccion()">
                            <label class="form-check-label" for="atencionDomicilio">A Domicilio</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><strong>Dirección (solo si es a domicilio)</strong></label>
                        <input type="text" name="ubicacion" id="direccionInput" class="form-control" placeholder="Ej. Calle #123" disabled>
                    </div>

                    <!-- Estado de la cita -->
                    <div class="mb-3">
                        <label><strong>Estado de la cita</strong></label>
                        <input type="hidden" name="estado" value="pendiente">
                        <input type="text" class="form-control" value="Pendiente" disabled>
                    </div>


                    <div class="mb-3">
                        <label><strong>Requerimientos Especiales</strong></label>
                        <textarea name="notas" class="form-control" rows="2"></textarea>
                    </div>

                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4 me-3">Guardar Cita</button>
                    <a href="{{ route('agendas.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                </div>
                <!-- Modal Bootstrap -->
                <div class="modal fade" id="modalServicio" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="modalServicioTitulo" class="modal-title"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img id="modalServicioImg" class="img-fluid mb-3 rounded">
                                <p id="modalServicioDesc"></p>
                                <p><strong>Duración:</strong> <span id="modalDuracion"></span> min</p>
                                <p><strong>Precio:</strong> Bs. <span id="modalPrecio"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>



<script>
    const servicios = new Map();
    let totalDuracion = 0;
    let totalPrecio = 0;

    function mostrarDetallesServicio(nombre, imagen, descripcion, duracion, precio) {
        document.getElementById('modalServicioTitulo').textContent = nombre;
        document.getElementById('modalServicioImg').src = imagen;
        document.getElementById('modalServicioDesc').textContent = descripcion;
        document.getElementById('modalDuracion').textContent = duracion;
        document.getElementById('modalPrecio').textContent = precio;

        new bootstrap.Modal(document.getElementById('modalServicio')).show();
    }

    function agregarServicio() {
        const select = document.getElementById('servicioSelect');
        const selected = select.options[select.selectedIndex];
        const servicioId = selected.value;
        const nombre = selected.text;
        const duracion = parseInt(selected.dataset.duration);
        const precio = parseFloat(selected.dataset.price);
        const imagen = selected.dataset.image;
        const descripcion = selected.dataset.description;

        let personal;
        try {
            personal = JSON.parse(selected.dataset.personal);
        } catch (e) {
            console.error('PERSONAL RAW:', selected.dataset.personal);
            alert('JSON inválido:\n' + e.message);
            return;
        }

        if (document.getElementById(`row-${servicioId}`)) {
            alert("Este servicio ya fue agregado.");
            return;
        }

        const cantidad = 1;
        const personalId = personal.length > 0 ? personal[0].id : null;

        const row = document.createElement('tr');
        row.id = `row-${servicioId}`;
        row.innerHTML = `
        <td><img src="${imagen}" alt="${nombre}" width="50" class="rounded" style="cursor:pointer"
            onclick="mostrarDetallesServicio('${nombre}', '${imagen}', '${descripcion}', ${duracion}, ${precio})"></td>
        <td>${nombre}</td>
        <td>${duracion} min</td>
        <td>Bs. ${precio}</td>
        <td>
            <select name="personal_por_servicio[${servicioId}]" class="form-control"
                onchange="actualizarOcultoPersonal(${servicioId}, this.value)">
                ${personal.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
            </select>
        </td>
        <td>
            <input type="number" name="cantidad_personas[${servicioId}]" value="${cantidad}" min="1"
                class="form-control"
                onchange="actualizarOcultoCantidad(${servicioId}, this.value); recalcularTotales();"

                data-servicio-id="${servicioId}"
                data-duracion="${duracion}" data-precio="${precio}">
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger"
                onclick="quitarServicio('${servicioId}')">X</button>
        </td>
    `;
        document.querySelector('#tablaServicios tbody').appendChild(row);

        // Inputs ocultos
        const hiddenContainer = document.getElementById('hiddenServicios');
        hiddenContainer.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="servicios[]" value="${servicioId}" id="input-${servicioId}">
        <input type="hidden" name="personal_por_servicio[${servicioId}]" value="${personalId}" id="input-personal-${servicioId}">
        <input type="hidden" name="cantidad_personas[${servicioId}]" value="${cantidad}" id="input-cantidad-${servicioId}">
    `);

        recalcularTotales();
    }

    function actualizarOcultoPersonal(servicioId, nuevoValor) {
        const input = document.getElementById(`input-personal-${servicioId}`);
        if (input) input.value = nuevoValor;
    }

    function actualizarOcultoCantidad(servicioId, nuevoValor) {
    const input = document.getElementById(`input-cantidad-${servicioId}`);
    if (input) input.value = nuevoValor;

    recalcularTotales(); // Asegura que se actualicen los totales
}





    function actualizarTotales(duracion, precio, cantidad = 1) {
        totalDuracion += duracion * cantidad;
        totalPrecio += precio * cantidad;

        document.getElementById('duracionTotal').value = totalDuracion;
        document.getElementById('precioTotal').value = totalPrecio.toFixed(2);

        // Convertir duración total a formato legible
        const horas = Math.floor(totalDuracion / 60);
        const minutos = totalDuracion % 60;
        const formato = `${totalDuracion} min (${horas > 0 ? horas + 'h ' : ''}${minutos}min)`;

        // Mostrar en un solo input de solo lectura
        document.getElementById('duracionTotalVisual').value = formato;
    }

    function recalcularTotales() {
        let totalDuracion = 0;
        let totalPrecio = 0;

        const filas = document.querySelectorAll('#tablaServicios tbody tr');

        filas.forEach(fila => {
            const cantidadInput = fila.querySelector('input[name^="cantidad_personas"]');
            const cantidad = parseInt(cantidadInput.value) || 1;
            const duracion = parseInt(cantidadInput.dataset.duracion);
            const precio = parseFloat(cantidadInput.dataset.precio);

            totalDuracion += duracion * cantidad;
            totalPrecio += precio * cantidad;
        });

        document.getElementById('duracionTotal').value = totalDuracion;
        document.getElementById('precioTotal').value = totalPrecio.toFixed(2);

        const horas = Math.floor(totalDuracion / 60);
        const minutos = totalDuracion % 60;
        const formato = `${totalDuracion} min (${horas > 0 ? horas + 'h ' : ''}${minutos}min)`;
        document.getElementById('duracionTotalVisual').value = formato;
    }

   function quitarServicio(servicioId) {
    const fila = document.getElementById(`row-${servicioId}`);
    if (fila) fila.remove();

    // Eliminar todos los inputs ocultos relacionados
    ['input-' + servicioId, 'input-personal-' + servicioId, 'input-cantidad-' + servicioId].forEach(id => {
        const input = document.getElementById(id);
        if (input) input.remove();
    });

    recalcularTotales();
}



    function eliminarServicio(valor) {
        servicios.delete(valor);
        renderizarServicios();
    }

    function renderizarServicios() {
        const container = document.getElementById('listaServicios');
        const hidden = document.getElementById('hiddenServicios');
        const inputDuracion = document.getElementById('duracionTotal');
        const inputPrecio = document.getElementById('precio_total');

        container.innerHTML = '';
        hidden.innerHTML = '';
        let duracionTotal = 0;
        let precioTotal = 0;

        servicios.forEach((servicio, valor) => {
            const option = document.querySelector(`#servicioSelect option[value="${valor}"]`);
            const personalMap = JSON.parse(option.dataset.personal); // ← Aquí obtenemos los personales

            // Crear contenedor
            const div = document.createElement('div');
            div.className = 'mb-3 p-2 border rounded';

            // Selector de personal
            let personalSelect = `<select name="personal_por_servicio[${valor}]" class="form-select mb-2">`;
            personalMap.forEach(p => {
                personalSelect += `<option value="${p.id}">${p.name}</option>`;
            });

            personalSelect += `</select>`;

            // Mostrar servicio con selector de personal
            div.innerHTML = `
            <div>
                <strong>${servicio.texto}</strong> (${servicio.duracion} min, Bs ${servicio.precio})<br>
                ${personalSelect}
                <input type="hidden" name="servicios[]" value="${valor}">
                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="eliminarServicio('${valor}')">Eliminar</button>
            </div>
        `;

            container.appendChild(div);

            duracionTotal += servicio.duracion;
            precioTotal += servicio.precio;
        });

        inputDuracion.value = duracionTotal;
        inputPrecio.value = precioTotal.toFixed(2);
    }

    function controlarDireccion() {
        const domicilioChecked = document.querySelector('input[name="tipo_atencion"][value="domicilio"]').checked;
        const direccionInput = document.getElementById('direccionInput');

        direccionInput.disabled = !domicilioChecked;
        if (!domicilioChecked) {
            direccionInput.value = '';
        }
    }

    window.onload = function() {
        controlarDireccion();

        // 🟦 Restaurar servicios si existen en old()
        const serviciosViejos = @json(old('servicios', []));
        const personalViejo = @json(old('personal_por_servicio', []));
        const cantidadesViejas = @json(old('cantidad_personas', []));

        serviciosViejos.forEach(servicioId => {
            const option = document.querySelector(`#servicioSelect option[value="${servicioId}"]`);
            if (!option) return;

            const nombre = option.text;
            const duracion = parseInt(option.dataset.duration);
            const precio = parseFloat(option.dataset.price);
            const imagen = option.dataset.image;
            const descripcion = option.dataset.description;
            const personal = JSON.parse(option.dataset.personal);

            const row = document.createElement('tr');
            row.id = `row-${servicioId}`;
            row.innerHTML = `
            <td><img src="${imagen}" width="50" class="rounded" style="cursor:pointer"
                onclick="mostrarDetallesServicio('${nombre}', '${imagen}', '${descripcion}', ${duracion}, ${precio})"></td>
            <td>${nombre}</td>
            <td>${duracion} min</td>
            <td>Bs. ${precio}</td>
            <td>
                <select name="personal_por_servicio[${servicioId}]" class="form-control">
                    ${personal.map(p => `<option value="${p.id}" ${p.id == personalViejo[servicioId] ? 'selected' : ''}>${p.name}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="number" name="cantidad_personas[${servicioId}]" value="${cantidadesViejas[servicioId] || 1}" min="1" class="form-control"
                    onchange="recalcularTotales()" data-servicio-id="${servicioId}"
                    data-duracion="${duracion}" data-precio="${precio}">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="quitarServicio('${servicioId}', ${duracion}, ${precio})">X</button>
            </td>
        `;

            document.querySelector('#tablaServicios tbody').appendChild(row);

            document.getElementById('hiddenServicios').insertAdjacentHTML('beforeend', `
            <input type="hidden" name="servicios[]" value="${servicioId}" id="input-${servicioId}">
        `);
        });

        recalcularTotales();
    };

    document.querySelector('form').addEventListener('submit', function(e) {
        if (servicios.size === 0) {
            alert('Debes agregar al menos un servicio.');
            e.preventDefault();
        }
    });
</script>



@endsection