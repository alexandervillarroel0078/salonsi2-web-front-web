@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Personal</h2>

    <form action="{{ route('personals.update', $personal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $personal->name) }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $personal->email) }}">
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $personal->phone) }}">
        </div>

        <div class="form-group">
            <label>Foto</label>
            <input type="text" name="photo_url" class="form-control" value="{{ old('photo_url', $personal->photo_url) }}">
        </div>

        <div class="form-group">
            <label>Estado</label>
            <input type="checkbox" name="status" value="1" {{ old('status', $personal->status) == 1 ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
