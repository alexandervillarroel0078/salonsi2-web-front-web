<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Servicios</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f8f8f8; }
    </style>
</head>
<body>

    <h2>Reporte de Servicios</h2>

    <table>
        <thead>
            <tr>
                @if(in_array('id', $columns)) <th>ID</th> @endif
                @if(in_array('name', $columns)) <th>Nombre</th> @endif
                @if(in_array('price', $columns)) <th>Precio</th> @endif
                @if(in_array('discount', $columns)) <th>Descuento</th> @endif
                @if(in_array('available', $columns)) <th>Disponible</th> @endif
                @if(in_array('category', $columns)) <th>Categoría</th> @endif
                @if(in_array('duration_minutes', $columns)) <th>Duración (min)</th> @endif
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                @if(in_array('id', $columns)) <td>{{ $service->id }}</td> @endif
                @if(in_array('name', $columns)) <td>{{ $service->name }}</td> @endif
                @if(in_array('price', $columns)) <td>Bs {{ number_format($service->price, 2) }}</td> @endif
                @if(in_array('discount', $columns)) <td>{{ $service->has_discount ? 'Bs ' . number_format($service->discount_price, 2) : 'No' }}</td> @endif
                @if(in_array('available', $columns)) <td>{{ $service->has_available ? 'Disponible' : 'No disponible' }}</td> @endif
                @if(in_array('category', $columns)) <td>{{ $service->category ?? 'Sin categoría' }}</td> @endif
                @if(in_array('duration_minutes', $columns)) <td>{{ $service->duration_minutes }} min</td> @endif
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
