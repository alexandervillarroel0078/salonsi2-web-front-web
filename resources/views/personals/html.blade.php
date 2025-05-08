<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Personal</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Reporte de Personal</h2>

    <table>
        <thead>
            <tr>
                @if(in_array('id', $columns)) <th>ID</th> @endif
                @if(in_array('name', $columns)) <th>Nombre</th> @endif
                @if(in_array('email', $columns)) <th>Email</th> @endif
                @if(in_array('phone', $columns)) <th>Teléfono</th> @endif
                @if(in_array('cargo_empleado_id', $columns)) <th>Cargo</th> @endif
                @if(in_array('status', $columns)) <th>Estado</th> @endif
            </tr>
        </thead>
        <tbody>
            @foreach($personals as $personal)
                <tr>
                    @if(in_array('id', $columns)) <td>{{ $personal->id }}</td> @endif
                    @if(in_array('name', $columns)) <td>{{ $personal->name }}</td> @endif
                    @if(in_array('email', $columns)) <td>{{ $personal->email }}</td> @endif
                    @if(in_array('phone', $columns)) <td>{{ $personal->phone }}</td> @endif
                    @if(in_array('cargo_empleado_id', $columns))
                        <td>{{ $personal->cargoEmpleado ? $personal->cargoEmpleado->cargo : 'Sin cargo' }}</td>
                    @endif
                    @if(in_array('status', $columns))
                        <td>{{ $personal->status ? 'Activo' : 'Inactivo' }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
