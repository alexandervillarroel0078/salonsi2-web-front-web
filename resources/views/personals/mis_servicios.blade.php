@extends('layouts.ap')

@section('content')
<div class="container">
    <h2>Mis Servicios Ofrecidos</h2>

    @if($servicios->isEmpty())
        <p>No tienes servicios asignados.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Duración</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->name }}</td>
                        <td>{{ $servicio->description }}</td>
                        <td>Bs {{ number_format($servicio->price, 2) }}</td>
                        <td>{{ $servicio->duration_minutes }} min</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
