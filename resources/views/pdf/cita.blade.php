<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cita #{{ $agenda->id }}</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 5px; border: 1px solid #000; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Cita N° {{ $agenda->id }}</h2>
        <p>Fecha: {{ $agenda->fecha }} | Hora: {{ $agenda->hora }}</p>
    </div>

    <p><strong>Cliente:</strong> {{ $agenda->cliente->name ?? '-' }}</p>
    <p><strong>Personal:</strong> {{ $agenda->personal->name ?? '-' }}</p>

    <h4>Servicios</h4>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Duración</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agenda->servicios as $servicio)
            <tr>
                <td>{{ $servicio->name }}</td>
                <td>{{ $servicio->duration_minutes }} min</td>
                <td>Bs {{ $servicio->has_discount ? $servicio->discount_price : $servicio->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> Bs {{ $agenda->precio_total }}</p>
</body>
</html>
