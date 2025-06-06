<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Citas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Listado de Citas</h2>
    <table>
        <thead>
            <tr>
                @foreach($columnas as $col)
                    <th>{{ strtoupper(str_replace('_', ' ', $col)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($agendas as $agenda)
                <tr>
                    @foreach($columnas as $col)
                        <td>
                            @switch($col)
                                @case('cliente_id')
                                    {{ $agenda->cliente->name ?? '-' }}
                                    @break
                                @case('personal_id')
                                    {{ $agenda->personal->name ?? '-' }}
                                    @break
                                @case('servicios')
                                    {{ $agenda->servicios->pluck('name')->join(', ') }}
                                    @break
                                @default
                                    {{ $agenda->$col ?? '-' }}
                            @endswitch
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
