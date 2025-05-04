@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Asistencias</h2>

    @can('crear asistencias')
    <a href="{{ route('asistencias.create') }}" class="btn btn-primary mb-3">Registrar Asistencia</a>
    @endcan

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Personal</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asistencias as $asistencia)
                <tr>
                    <td>{{ $asistencia->personal->name }}</td>
                    <td>{{ $asistencia->fecha }}</td>
                    <td>
                        @if($asistencia->estado === 'presente_local')
                            Presente (Salón)
                        @elseif($asistencia->estado === 'presente_domicilio')
                            Presente (Domicilio)
                        @else
                            Ausente
                        @endif
                    </td>
                    <td>{{ $asistencia->observaciones ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay asistencias registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $asistencias->links() }}
    </div>
</div>
@endsection
