<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Horarios</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f8f8f8; }
    </style>
</head>
<body>
    <h2>Reporte de Horarios</h2>
    <table>
        <thead>
            <tr>
                <th>Personal</th>
                <th>Día</th>
                <th>Fecha</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
                <tr>
                    <td>{{ $horario->personal->name }}</td>
                    <td>{{ $horario->day_name }}</td>
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
