<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Agenda;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PagoController extends Controller
{
    // 🔹 MÉTODO PARA PAGO CON STRIPE (tarjeta VISA, etc.)
    public function pagarConStripe($agendaId)
    {
        $agenda = Agenda::with('clientes')->findOrFail($agendaId);
        $cliente = Auth::user()->cliente;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd', // Simulación en USD
                    'product_data' => [
                        'name' => 'Pago de cita: ' . $agenda->codigo,
                    ],
                    'unit_amount' => $agenda->precio_total * 100, // Stripe usa centavos
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('pagos.success', ['agendaId' => $agenda->id]),
            'cancel_url' => url()->previous(),
        ]);

        return redirect($session->url);
    }

    // 🔹 REGISTRAR PAGO CUANDO EL STRIPE SEA EXITOSO
public function stripeSuccess($agendaId)
{
    $cliente = Auth::user()->cliente;

    $agenda = Agenda::findOrFail($agendaId);
   $agenda->estado = 'en_curso'; // Cambiar estado
    $agenda->save();

    Pago::create([
        'monto' => $agenda->precio_total,
        'estado' => 'pagado',
        'metodo_pago' => 'Stripe',
        'agenda_id' => $agendaId,
        'cliente_id' => $cliente->id,
    ]);

    return redirect()->route('clientes.agenda.index')->with('success', '✅ Pago realizado exitosamente con Stripe.');
}


    // 🔹 PAGO SIMULADO CON QR (opcional)
    public function pagarConQR($agendaId)
    {
        $agenda = Agenda::with('clientes')->findOrFail($agendaId);
        $cliente = Auth::user()->cliente;

        $contenidoQr = urlencode("Pago de cita\nCódigo: {$agenda->codigo}\nMonto: Bs {$agenda->precio_total}");
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?data={$contenidoQr}&size=200x200";

        return view('clientes.agenda.qr_simulado', [

            'agenda' => $agenda,
            'cliente' => $cliente,
            'qrUrl' => $qrUrl
        ]);
    }

    // 🔹 REGISTRO DEL PAGO SIMULADO
public function confirmarPagoQR($agendaId)
{
    $cliente = Auth::user()->cliente;

    // Cambiar estado de la agenda a "en curso"
    $agenda = Agenda::findOrFail($agendaId);
    $agenda->estado = 'en_curso';
    $agenda->save();

    // Crear el pago
    Pago::create([
        'monto' => $agenda->precio_total,
        'estado' => 'pagado',
        'metodo_pago' => 'QR',
        'agenda_id' => $agendaId,
        'cliente_id' => $cliente->id,
    ]);

    return redirect()->route('clientes.agenda.index')->with('success', '✅ Pago confirmado manualmente vía QR.');
}
}
