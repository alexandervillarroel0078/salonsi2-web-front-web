<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            margin: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Lista de Clientes</h2>

    <table>
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ ucfirst($column) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    @foreach($columns as $column)
                        <td>{{ $cliente->$column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>
