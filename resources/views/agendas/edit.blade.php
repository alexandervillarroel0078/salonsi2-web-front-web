<!-- Select2 (solo para servicios múltiples) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Editar Cita</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('agendas.update', $agenda->id) }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Cliente</strong></label>
                        <select name="cliente_id" class="form-select" required>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ $agenda->cliente_id == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Personal Asignado</strong></label>
                        <select name="personal_id" class="form-select" required>
                            @foreach($personals as $personal)
                            <option value="{{ $personal->id }}" {{ $agenda->personal_id == $personal->id ? 'selected' : '' }}>
                                {{ $personal->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Servicios solicitados</strong></label>
                    <select name="servicios[]" id="servicios" class="form-select" multiple required>
                        @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ in_array($servicio->id, $agenda->servicios->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $servicio->name }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Selecciona uno o varios servicios.</small>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Fecha</strong></label>
                        <input type="date" name="fecha" class="form-control" required value="{{ $agenda->fecha }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Hora</strong></label>
                        <input type="time" name="hora" class="form-control" required value="{{ $agenda->hora }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Duración estimada (minutos)</strong></label>
                    <input type="number" name="duracion" class="form-control" value="{{ $agenda->duracion }}" readonly>
                </div>

                @php
                $ubicacion = strtolower(Str::ascii($agenda->ubicacion));
                @endphp
                <div class="mb-3">
                    <label class="form-label"><strong>Ubicación</strong></label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ubicacion" value="salon" {{ $ubicacion === 'salon' ? 'checked' : '' }}>
                        <label class="form-check-label">En Salón</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ubicacion" value="domicilio" {{ $ubicacion === 'domicilio' ? 'checked' : '' }}>
                        <label class="form-check-label">A Domicilio</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Dirección (si es a domicilio)</strong></label>
                    <input type="text" name="ubicacion" class="form-control" value="{{ $agenda->ubicacion }}">
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Estado de la cita</strong></label>
                    <input type="hidden" name="estado" value="{{ $agenda->estado }}">
                    <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $agenda->estado)) }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Requerimientos Especiales</strong></label>
                    <textarea name="observaciones_cliente" class="form-control" rows="2">{{ $agenda->observaciones_cliente }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Método de Pago</strong></label>
                        <select name="metodo_pago" class="form-select">
                            <option value="">-- Seleccionar --</option>
                            <option value="efectivo" {{ $agenda->metodo_pago == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="tarjeta" {{ $agenda->metodo_pago == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="transferencia" {{ $agenda->metodo_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Precio Total</strong></label>
                        <input type="text" name="precio_total" class="form-control" value="{{ $agenda->precio_total }}" readonly>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4 me-3">Actualizar Cita</button>
                    <a href="{{ route('agendas.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

<script>
    $(document).ready(function() {
        $('#servicios').select2({
            placeholder: "Selecciona los servicios",
            width: '100%'
        });
    });
</script>
