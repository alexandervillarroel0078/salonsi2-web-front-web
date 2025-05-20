@extends('layouts.ap')

@section('title', 'Gestión de Backups')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Listado de archivos de respaldo</h4>

        @can('crear backups')
        <a href="{{ route('backups.run') }}" class="btn btn-sm btn-primary">Generar Backup</a>
        @endcan
    </div>

    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre del Archivo</th>
                        <th>Tamaño</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($backups as $backup)
                    <tr>
                        <td>{{ $backup['name'] }}</td>
                        <td>{{ number_format($backup['size'] / 1048576, 2) }} MB</td>
                        <td>{{ \Carbon\Carbon::createFromTimestamp($backup['date'])->format('Y-m-d H:i:s') }}</td>
                        <td>
                            @can('descargar backups')
                            <a href="{{ route('backups.download', $backup['name']) }}" class="btn btn-sm btn-success">
                                Descargar
                            </a>
                            @endcan
{{-- Botón "Restaurar" decorativo (sin funcionalidad activa) --}}
@can('restaurar backups')
<button class="btn btn-sm btn-warning" title="Función disponible solo con acceso SSH o VPS" disabled>
    Restaurar
</button>
@endcan
                            @can('eliminar backups')
                            <form action="{{ route('backups.destroy', $backup['name']) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este backup?')">
                                    Eliminar
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay backups disponibles.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
