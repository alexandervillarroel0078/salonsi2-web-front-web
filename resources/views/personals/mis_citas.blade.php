@extends('layouts.ap') {{-- o tu layout principal --}}

@section('content')
<div class="container">
    <h1 class="mb-4">Mis Citas Asignadas Personals</h1>

    @if($agendas->isEmpty())
    <div class="alert alert-info">No tienes citas asignadas.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente(s)</th>
                    <th>Servicios</th>
                    <th>Tipo de Atención</th>
                    <th>Ubicación</th>
                    <th>Notas</th>
                    <th>Duración</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agendas as $agenda)
                <tr>
                    <td>{{ $agenda->codigo }}</td>
                    <td>{{ $agenda->fecha }}</td>
                    <td>{{ $agenda->hora }}</td>
                    <td>
                        @php $cli = $agenda->clientes->first(); @endphp
                        {{ $cli?->name ?? '—' }}
                    </td>
                    <td>
                        @foreach($agenda->servicios as $servicio)
                        {{ $servicio->name }} (x{{ $servicio->pivot->cantidad }})<br>
                        @endforeach
                    </td>
                    <td>{{ ucfirst($agenda->tipo_atencion) }}</td>
                    <td>{{ $agenda->ubicacion }}</td>
                    <td>{{ $agenda->notas }}</td>
                    <td>{{ $agenda->duracion }} min</td>
                    <td>{{ ucfirst($agenda->estado) }}</td>
                    <td>
                        <a href="{{ route('personals.citas.show', $agenda->id) }}" class="btn btn-sm btn-primary">
                            Ver detalle
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection