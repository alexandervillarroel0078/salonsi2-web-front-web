@extends('plantilla')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@section('title', 'Inicio')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Salon de belleza</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Panel principal</li>
    </ol>
 
    <div class="row">
        @can('ver usuarios')
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white bg-primary shadow-sm rounded-3 text-center h-100 border-0" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h5 class="card-title">Usuarios</h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalOpcionesUsuarios" class="btn btn-light btn-sm mt-3">
                        Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcan


        <div class="modal fade" id="modalOpcionesUsuarios" tabindex="-1" aria-labelledby="modalOpcionesUsuariosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalOpcionesUsuariosLabel">Opciones de Usuarios</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="{{ route('users.index') }}"><i class="fas fa-user me-2"></i> Lista de usuarios</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('roles.index') }}"><i class="fas fa-user-shield me-2"></i> Roles</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @canany(['ver servicios', 'ver promociones', 'ver combos', 'ver cargos'])
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white bg-info shadow-sm rounded-3 text-center h-100 border-0" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-cut fa-3x mb-3"></i>
                    <h5 class="card-title">Servicios</h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalOpcionesServicios" class="btn btn-light btn-sm mt-3">
                        Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcanany


        <div class="modal fade" id="modalOpcionesServicios" tabindex="-1" aria-labelledby="modalOpcionesServiciosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="modalOpcionesServiciosLabel">Opciones de Servicios</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">

                            @can('ver servicios')
                            <li class="list-group-item">
                                <a href="{{ route('services.index') }}">
                                    <i class="fas fa-cut me-2"></i> Lista de servicios
                                </a>
                            </li>
                            @endcan

                            @can('ver combos')
                            <li class="list-group-item">
                                <a href="{{ route('combos.index') }}">
                                    <i class="fas fa-layer-group me-2"></i> Lista de combos
                                </a>
                            </li>
                            @endcan

                            @can('ver cargos')
                            <li class="list-group-item">
                                <a href="{{ route('cargos.index') }}">
                                    <i class="fas fa-tags me-2"></i> Categoría de servicios
                                </a>
                            </li>
                            @endcan

                            @can('ver promociones')
                            <li class="list-group-item">
                                <a href="{{ route('promotions.index') }}">
                                    <i class="fas fa-percent me-2"></i> Promociones
                                </a>
                            </li>
                            @endcan

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @canany(['ver empleados', 'ver asistencias', 'ver horarios'])
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white bg-success shadow-sm rounded-3 text-center h-100 border-0" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-user-tie fa-3x mb-3"></i>
                    <h5 class="card-title">Personal</h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalOpcionesPersonal" class="btn btn-light btn-sm mt-3">
                        Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcanany


        {{-- Modal: Personal --}}
        <div class="modal fade" id="modalOpcionesPersonal" tabindex="-1" aria-labelledby="modalOpcionesPersonalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="modalOpcionesPersonalLabel">Opciones del Personal</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            @can('ver empleados')
                            <li class="list-group-item">
                                <a href="{{ route('personals.index') }}">
                                    <i class="fas fa-users me-2"></i> Personal del salón
                                </a>
                            </li>
                            @endcan
                            @can('ver asistencias')
                            <li class="list-group-item">
                                <a href="{{ route('asistencias.index') }}">
                                    <i class="fas fa-user-check me-2"></i> Asistencia
                                </a>
                            </li>
                            @endcan
                            <li class="list-group-item">
                                <a href="{{ route('cargos.index') }}">
                                    <i class="fas fa-briefcase me-2"></i> Cargos del personal
                                </a>
                            </li>
                            @can('ver horarios')
                            <li class="list-group-item">
                                <a href="{{ route('horarios.index') }}">
                                    <i class="fas fa-clock me-2"></i> Horarios
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        @can('ver clientes')
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white bg-info shadow-sm rounded-3 text-center h-100 border-0" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h5 class="card-title">Clientes</h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalClientes" class="btn btn-light btn-sm mt-3">
                        Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcan


        {{-- Modal: Clientes --}}
        <div class="modal fade" id="modalClientes" tabindex="-1" aria-labelledby="modalClientesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="modalClientesLabel">Clientes</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="{{ route('clientes.index') }}">
                                    <i class="fas fa-users me-2"></i> Lista de clientes
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @can('ver citas')
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white bg-warning shadow-sm rounded-3 text-center h-100 border-0" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                    <h5 class="card-title">Agenda</h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalAgenda" class="btn btn-light btn-sm mt-3">
                        Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcan


        {{-- Modal: Agenda --}}
        <div class="modal fade" id="modalAgenda" tabindex="-1" aria-labelledby="modalAgendaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="modalAgendaLabel">Gestión de Agenda</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="{{ route('agendas.index') }}">
                                    <i class="fas fa-calendar-alt me-2"></i> Ver agenda
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



        @can('ver backups')
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white bg-dark shadow-sm rounded-3 text-center h-100 border-0" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-database fa-3x mb-3"></i>
                    <h5 class="card-title">Backup del sistema</h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalBackup" class="btn btn-light btn-sm mt-3">
                        Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcan


        {{-- Modal: Backup del sistema --}}
        <div class="modal fade" id="modalBackup" tabindex="-1" aria-labelledby="modalBackupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="modalBackupLabel">Backup del sistema</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="{{ route('backups.index') }}">
                                    <i class="fas fa-database me-2"></i> Ver backups disponibles
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </div>
    
 
    
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush