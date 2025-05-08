@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Registrar Nueva Cita</h4>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" action="{{ route('agendas.store') }}">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label><strong>Cliente</strong></label>
                        <select name="cliente_id" class="form-control" required>
                            <option value="">-- Seleccionar Cliente --</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>

                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label><strong>Personal Asignado</strong></label>
                        <select name="personal_id" class="form-control" required>
                            <option value="">-- Seleccionar Personal --</option>
                            @foreach($personales as $personal)
                            <option value="{{ $personal->id }}">{{ $personal->name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <!-- 🟦 Servicios que solicita el cliente -->
                <div class="form-group">
                    <label><strong>Servicios solicitados</strong></label>
                    <div class="input-group">
                        <select id="servicioSelect" class="form-control">
                            @foreach($servicios as $servicio)
                            <option
                                value="{{ $servicio->id }}"
                                data-duration="{{ $servicio->duration_minutes }}"
                                data-price="{{ $servicio->has_discount ? $servicio->discount_price : $servicio->price }}">
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

                <div class="form-group">
                    <label><strong>Servicios seleccionados</strong></label>
                    <div id="listaServicios" class="border rounded p-2 d-flex flex-wrap gap-2">
                        <!-- Chips -->
                    </div>
                </div>

                <!-- Inputs ocultos -->
                <div id="hiddenServicios"></div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label><strong>Fecha</strong></label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label><strong>Hora</strong></label>
                        <input type="time" name="hora" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label><strong>Duración estimada (minutos)</strong></label>
                    <input type="number" name="duracion" class="form-control" id="duracionTotal" readonly>
                </div>


                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_atencion" value="salon" checked>
                    <label class="form-check-label">En Salón</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_atencion" value="domicilio">
                    <label class="form-check-label">A Domicilio</label>
                </div>


                <div class="mb-3">
                    <label><strong>Dirección (si es a domicilio)</strong></label>
                    <input type="text" name="ubicacion" class="form-control" placeholder="Ej. Av. Central #123">
                </div>
                <!-- Estado de la cita -->
                <div class="mb-3">
                    <label><strong>Estado de la cita</strong></label>
                    <input type="hidden" name="estado" value="pendiente">
                    <input type="text" class="form-control" value="Pendiente" disabled>
                </div>


                <div class="mb-3">
                    <label><strong>Requerimientos Especiales</strong></label>
                    <textarea name="observaciones_cliente" class="form-control" rows="2"></textarea>
                </div>



                <div class="row mb-3">
                    <div class="col-md-6">
                        <label><strong>Método de Pago</strong></label>
                        <select name="metodo_pago" class="form-control">
                            <option value="">-- Seleccionar --</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label><strong>Precio Total</strong></label>
                        <input type="text" name="precio_total" id="precio_total" class="form-control" readonly>
                    </div>

                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4 me-3">Guardar Cita</button>
                    <a href="{{ route('agendas.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                </div>

            </div>
        </div>
    </form>
</div>
<script>
    const servicios = new Map();

    function agregarServicio() {
        const select = document.getElementById('servicioSelect');
        const valor = select.value;
        const texto = select.options[select.selectedIndex].text;
        const duracion = parseInt(select.options[select.selectedIndex].dataset.duration);
        const precio = parseFloat(select.options[select.selectedIndex].dataset.price);

        if (!servicios.has(valor)) {
            servicios.set(valor, {
                texto,
                duracion,
                precio
            });
            renderizarServicios();
        }
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
            const chip = document.createElement('span');
            chip.className = 'badge bg-info text-white px-3 py-2 me-2 mb-2 rounded-pill d-inline-flex align-items-center';
            chip.innerHTML = `
                <span class="me-2">${servicio.texto} (${servicio.duracion} min, Bs ${servicio.precio})</span>
                <span style="cursor:pointer;" onclick="eliminarServicio('${valor}')">&times;</span>
            `;
            container.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'servicios[]';
            input.value = valor;
            hidden.appendChild(input);

            duracionTotal += servicio.duracion;
            precioTotal += servicio.precio;
        });

        inputDuracion.value = duracionTotal;
        inputPrecio.value = precioTotal.toFixed(2); // muestra como "120.50"
    }
    document.querySelector('form').addEventListener('submit', function(e) {
        if (servicios.size === 0) {
            alert('Debes agregar al menos un servicio.');
            e.preventDefault();
        }
    });
</script>


@endsection