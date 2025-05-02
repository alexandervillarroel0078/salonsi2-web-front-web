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

                <a class="nav-link" href="{{ route('users.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Usuarios
                </a>

                <a class="nav-link" href="{{ route('roles.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-person-circle-plus"></i></div>
                    Roles
                </a>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmpleados" aria-expanded="false" aria-controls="collapseEmpleados">
                    <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
                    servicios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEmpleados" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('services.index') }}">Lista de servicios</a>
                        <a class="nav-link" href="{{ route('cargos.index') }}">Cartegoria de servicios</a>
                    </nav>
                </div>


                <a class="nav-link" href="{{ route('personals.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                    Personal del salon
                </a>


                <a class="nav-link" href="{{ route('clientes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Clientes
                </a>

                <a class="nav-link" href="{{ route('horarios.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                    Horarios
                </a>

                <a class="nav-link" href="{{ route('bitacora.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Bitácora
                </a>

                <a class="nav-link" href="{{ route('logout') }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-sign-out" aria-hidden="true"></i></div>
                    Salir
                </a>
            </div>
        </div>
    </nav>
</div>