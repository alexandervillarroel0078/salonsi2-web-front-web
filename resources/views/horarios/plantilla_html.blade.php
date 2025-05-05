<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horarios</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Reporte de Horarios</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Personal</th>
                <th>Fecha</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($horarios as $horario)
            <tr>
                <td>{{ $horario->id }}</td>
                <td>{{ $horario->personal->name }}</td>
                <td>{{ $horario->date }}</td>
                <td>{{ $horario->start_time }}</td>
                <td>{{ $horario->end_time }}</td>
                <td>{{ $horario->available ? 'Sí' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
