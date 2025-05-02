@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Cliente</h2>

    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $cliente->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email) }}" required>
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $cliente->phone) }}">
        </div>

        <div class="form-group">
            <label>Estado</label>
            <input type="checkbox" name="status" value="1" {{ old('status', $cliente->status) ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
