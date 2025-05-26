@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4>Historial de Movimientos de Inventario</h4>

    {{-- Mensajes de éxito y error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('inventario.index') }}" class="btn btn-secondary mb-3">Volver al Inventario</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Motivo</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $mov)
            <tr>
                <td>{{ $mov->created_at }}</td>
                <td>{{ $mov->producto->nombre ?? '-' }}</td>
                <td>
                    @if($mov->tipo === 'entrada')
                        <span class="badge bg-success">Entrada</span>
                    @else
                        <span class="badge bg-danger">Salida</span>
                    @endif
                </td>
                <td>{{ $mov->cantidad }}</td>
                <td>{{ $mov->motivo }}</td>
                <td>{{ $mov->usuario->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Paginación --}}
    {{ $movimientos->links() }}
</div>
@endsection