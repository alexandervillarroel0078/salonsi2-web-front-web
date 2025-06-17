<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Inicio</div>

                @auth
                <div class="px-3 py-2 text-white small border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-circle me-2"></i>
                        <div>
                            <strong>{{ auth()->user()->name }}</strong><br>
                            <small>{{ auth()->user()->email }}</small><br>

                            {{-- Mostrar rol --}}
                            <small>
                                Rol: {{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}
                            </small><br>

                            {{-- Mostrar nombre de cliente o personal si aplica --}}
                            @if(auth()->user()->cliente)
                            <small>Cliente: {{ auth()->user()->cliente->name }}</small>
                            @elseif(auth()->user()->personal)
                            <small>Personal: {{ auth()->user()->personal->name }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @endauth


                <a class="nav-link" href="{{ route('panel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Inicio
                </a>

                <div class="sb-sidenav-menu-heading">Módulos</div>

                @canany(['ver usuarios', 'ver roles'])
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Usuarios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsuarios" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">

                        @can('ver usuarios')
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Lista de usuarios
                        </a>
                        @endcan

                        @can('ver roles')
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                            Roles
                        </a>
                        @endcan

                    </nav>
                </div>
                @endcanany

                @canany(['ver servicios', 'ver promociones', 'ver combos'])
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServicios" aria-expanded="false" aria-controls="collapseServicios">
                    <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
                    Servicios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseServicios" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">

                        @can('ver servicios')
                        <a class="nav-link" href="{{ route('services.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-cut"></i></div>
                            Lista de servicios
                        </a>
                        @endcan

                        @can('ver combos')
                        <a class="nav-link" href="{{ route('combos.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                            Lista de Combos
                        </a>
                        @endcan

                        @can('ver cargos') {{-- Si usas categorías o cargos de servicios --}}
                        <a class="nav-link" href="{{ route('cargos.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                            Categoría de servicios
                        </a>
                        @endcan

                        @can('ver promociones')
                        <a class="nav-link" href="{{ route('promotions.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-percent"></i></div>
                            Promociones
                        </a>
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
                        <a class="nav-link" href="{{ route('personals.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Personal del salón
                        </a>
                        @endcan

                        @can('ver asistencias')
                        <a class="nav-link" href="{{ route('asistencias.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-check"></i></div>
                            Asistencia
                        </a>
                        @endcan

                        <a class="nav-link" href="{{ route('cargos.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                            Cargos del personal
                        </a>

                        @can('ver horarios')
                        <a class="nav-link" href="{{ route('horarios.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                            Horarios
                        </a>
                        @endcan

                    </nav>
                </div>
                @endcanany


                @can('ver clientes')
                <a class="nav-link" href="{{ route('clientes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Clientes
                </a>
                @endcan

                @can('Citas del cliente')
                <a class="nav-link" href="{{ route('clientes.agenda.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                    Mis Citas
                </a>
                @endcan

                @can('Citas del personal')
                <a class="nav-link" href="{{ route('personals.mis_citas') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                    Citas asignadas
                </a>
                @endcan
                @can('Servicios del personal')
                <a class="nav-link" href="{{ route('personal.mis_servicios') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-concierge-bell"></i></div>
                    Servicios que realizo
                </a>
                @endcan



                @can('ver citas')
                <a class="nav-link" href="{{ route('agendas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                    Gestionar agenda
                </a>
                @endcan

                @canany(['ver inventario', 'registrar movimientos', 'ver movimientos inventario'])
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInventario" aria-expanded="false" aria-controls="collapseInventario">
                    <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                    Gestionar Inventario
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseInventario" aria-labelledby="headingInventario" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">

                        @can('ver sucursales')
                        <a class="nav-link" href="{{ route('sucursales.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Sucursales
                        </a>
                        @endcan

                        @can('ver inventario')
                        <a class="nav-link" href="{{ route('inventario.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                            Stock Actual
                        </a>
                        @endcan

                        @can('registrar movimientos inventario')
                        <a class="nav-link" href="{{ route('inventario.create') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                            Registrar Movimiento
                        </a>
                        @endcan

                        @can('ver movimientos inventario')
                        <a class="nav-link" href="{{ route('inventario.movimientos') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Historial de Movimientos
                        </a>
                        @endcan
                        @can('ver productos')
                        <a class="nav-link" href="{{ route('productos.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                            Productos / Insumos
                        </a>
                        @endcan

                    </nav>
                </div>
                @endcanany

                @can('ver backups')
                <a class="nav-link" href="{{ route('backups.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                    Backup del sistema
                </a>
                @endcan


                <a class="nav-link" href="{{ route('soporte') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
                    Soporte
                </a>


                @can('ver sugerencias')
                <a class="nav-link" href="{{ route('sugerencias.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                    Sugerencias
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