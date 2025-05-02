@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Nuevo Personal</h2>

    <form action="{{ route('personals.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label>Foto</label>
            <input type="text" name="photo_url" class="form-control" value="{{ old('photo_url') }}">
        </div>

        <div class="form-group">
            <label>Estado</label>
            <input type="checkbox" name="status" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
