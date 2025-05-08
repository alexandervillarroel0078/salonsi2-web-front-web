<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="{{ route('panel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Inicio
                </a>

                <div class="sb-sidenav-menu-heading">Módulos</div>

                @can('ver usuarios')
                <a class="nav-link" href="{{ route('users.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Usuarios
                </a>
                @endcan

                @can('ver roles')
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-person-circle-plus"></i></div>
                    Roles
                </a>
                @endcan

                @canany(['ver servicios', 'ver promociones', 'ver combos'])
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServicios" aria-expanded="false" aria-controls="collapseServicios">
                    <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
                    Servicios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseServicios" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @can('ver servicios')
                        <a class="nav-link" href="{{ route('services.index') }}">Lista de servicios</a>
                        @endcan
                        @can('ver combos')
                        <a class="nav-link" href="{{ route('combos.index') }}">Lista de Combos</a>
                        @endcan
                        @can('ver cargos') {{-- Si usas categorías o cargos de servicios --}}
                        <a class="nav-link" href="{{ route('cargos.index') }}">Categoría de servicios</a>
                        @endcan
                        @can('ver promociones')
                        <a class="nav-link" href="{{ route('promotions.index') }}">Promociones</a>
                        @endcan
                    </nav>
                </div>
                @endcanany

                @canany(['ver empleados', 'ver asistencias'])
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="false" aria-controls="collapsePersonal">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                    Personal
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePersonal" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @can('ver empleados')
                        <a class="nav-link" href="{{ route('personals.index') }}">Personal del salón</a>
                        @endcan
                        @can('ver asistencias')
                        <a class="nav-link" href="{{ route('asistencias.index') }}">Asistencia</a>
                        @endcan
                        {{-- Solo texto temporal --}}
                        <a class="nav-link" href="{{ route('cargos.index') }}">Cargos del personal</a>

                    </nav>
                </div>
                @endcanany

                @can('ver clientes')
                <a class="nav-link" href="{{ route('clientes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Clientes
                </a>
                @endcan

                @can('ver citas')
                <a class="nav-link" href="{{ route('agendas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                    Gestionar agenda
                </a>
                @endcan

                @can('ver horarios')
                <a class="nav-link" href="{{ route('horarios.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                    Horarios
                </a>
                @endcan



                @can('ver backups')
                <a class="nav-link" href="{{ route('backups.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                    Backup del sistema
                </a>
                @endcan

                <a class="nav-link" href="{{ route('logout') }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-sign-out" aria-hidden="true"></i></div>
                    Salir
                </a>
            </div>
        </div>
    </nav>
</div>