@extends('layouts.ap')

@section('content')
<div class="container mt-4 text-center">
    <h3 class="mb-4">Pago Simulado por QR</h3>

    <div class="mb-4">
        <p><strong>Cliente:</strong> {{ $cliente->name }}</p>
        <p><strong>Código de la Cita:</strong> {{ $agenda->codigo }}</p>
        <p><strong>Monto a pagar:</strong> Bs {{ $agenda->precio_total }}</p>
    </div>

    <div class="mb-4">
        <img src="{{ $qrUrl }}" alt="Código QR">
        <p class="mt-2">Escanee el código con su app bancaria para simular el pago.</p>
    </div>

    <form id="formConfirmarPago" action="{{ route('pagos.qr.confirmar', $agenda->id) }}" method="POST">
        @csrf
        <button id="btnConfirmar" type="submit" class="btn btn-success">Confirmar Pago</button>
    </form>

    <div id="spinner" class="mt-4" style="display:none;">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-2">Confirmando pago...</p>
    </div>

    <div class="mt-3">
        <a href="{{ route('clientes.agenda.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>

<script>
    document.getElementById('formConfirmarPago').addEventListener('submit', function(e) {
        e.preventDefault();

        // Ocultar botón y mostrar spinner
        document.getElementById('btnConfirmar').style.display = 'none';
        document.getElementById('spinner').style.display = 'block';

        // Espera 3 segundos y luego envía el formulario
        setTimeout(() => {
            e.target.submit();
        }, 3000);
    });
</script>
@endsection
