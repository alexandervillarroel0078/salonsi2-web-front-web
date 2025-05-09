@extends('layouts.ap')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-3 border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mi Perfil</h5>
                    <a href="#" class="btn btn-light btn-sm"><i class="fas fa-edit me-1"></i> Editar</a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        {{-- Contenedor de la foto --}}
                        <div class="me-4">
                            <div class="position-relative" style="width: 120px; height: 120px;">
                                <img src="https://via.placeholder.com/120" alt="Foto de perfil"
                                    class="rounded-circle border border-3 border-primary shadow"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1" title="Foto de perfil">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Información del usuario --}}
                        <div>
                            <h4 class="mb-1">Nombre del Usuario</h4>
                            <p class="mb-0 text-muted">correo@ejemplo.com</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Teléfono</strong></label>
                            <p class="form-control-plaintext">+591 70000000</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Rol</strong></label>
                            <p class="form-control-plaintext">Administrador</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Fecha de registro</strong></label>
                            <p class="form-control-plaintext">01/01/2024</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Último acceso</strong></label>
                            <p class="form-control-plaintext">08/05/2025 14:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection