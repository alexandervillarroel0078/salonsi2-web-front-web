<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Citas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Agenda de Citas</h2>

    <table>
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ ucfirst($column) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($agendas as $agenda)
                <tr>
                    @foreach($columns as $column)
                        <td>
                            @if($column == 'cliente_id')
                                {{ $agenda->cliente->name ?? 'No asignado' }}
                            @elseif($column == 'personal_id')
                                {{ $agenda->personal->name ?? 'No asignado' }}
                            @else
                                {{ $agenda->$column }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
