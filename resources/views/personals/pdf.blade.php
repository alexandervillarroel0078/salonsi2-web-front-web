<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Personal</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h2>Reporte de Personal</h2>

    <table>
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($personals as $personal)
                <tr>
                    @foreach($columns as $column)
                        <td>
                            @if($column === 'status')
                                {{ $personal->$column ? 'Activo' : 'Inactivo' }}
                            @elseif($column === 'cargo_empleado_id' && $personal->cargoEmpleado)
                                {{ $personal->cargoEmpleado->cargo }}
                            @elseif($column === 'photo_url')
                                <img src="{{ $personal->$column }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                {{ $personal->$column }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
