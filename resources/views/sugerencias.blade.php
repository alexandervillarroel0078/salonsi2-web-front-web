@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h3><i class="fas fa-comments text-primary"></i> Sugerencias de Usuarios</h3>
    <p class="text-muted">Aquí puedes revisar todos los comentarios enviados desde el centro de soporte.</p>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Sugerencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>17/05/2025 14:35</td>
                        <td>Juan Pérez</td>
                        <td>Sería útil poder reprogramar una cita desde la agenda directamente.</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>16/05/2025 09:20</td>
                        <td>María López</td>
                        <td>Agregar un botón para imprimir el recibo desde la pantalla de historial.</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>15/05/2025 17:10</td>
                        <td>Ana Torres</td>
                        <td>Me gustaría poder calificar los servicios con estrellas.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
