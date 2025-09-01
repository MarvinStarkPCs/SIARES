<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard'); ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('img/logo colegio.png'); ?>" alt="">
        </div>
    </a>

    <!-- ADMINISTRADOR -->
    <?php if (session()->get('role_id') == 1): ?>
        <hr class="sidebar-divider my-0">

        <!-- Home -->
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Home</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Gestión</div>

        <!-- Matricula -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/matricula'); ?>">
                <i class="fas fa-user-plus"></i>
                <span>Matricula / Rematricula</span>
            </a>
        </li>

        <!-- Reciclaje -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/reciclaje'); ?>">
                <i class="fas fa-recycle"></i>
                <span>Reciclaje (Vista General)</span>
            </a>
        </li>

        <!-- Usuarios -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/usermanagement'); ?>">
                <i class="fas fa-users-cog"></i>
                <span>Gestión de Usuarios</span>
            </a>
        </li>

        <!-- Seguridad -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/changepassword'); ?>">
                <i class="fas fa-key"></i>
                <span>Cambiar Contraseña</span>
            </a>
        </li>


    <!-- ESTUDIANTE -->
    <?php elseif (session()->get('role_id') == 2): ?>
        <hr class="sidebar-divider my-0">

        <!-- Home -->
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('estudiante/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Home</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Reciclaje</div>

        <!-- Consultar material reciclado -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('estudiante/mi-reporte'); ?>">
                <i class="fas fa-search"></i>
                <span>Ver Material Reciclado</span>
            </a>
        </li>

        <!-- Seguridad -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('estudiante/changepassword'); ?>">
                <i class="fas fa-key"></i>
                <span>Cambiar Contraseña</span>
            </a>
        </li>


    <!-- DOCENTE -->
    <?php elseif (session()->get('role_id') == 3): ?>
        <hr class="sidebar-divider my-0">

        <!-- Home -->
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('docente/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Home</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Reciclaje</div>

        <!-- Registrar material reciclado -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('docente/reciclaje'); ?>">
                <i class="fas fa-plus-circle"></i>
                <span>Registrar Material</span>
            </a>
        </li>

        <!-- Seguridad -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('docente/changepassword'); ?>">
                <i class="fas fa-key"></i>
                <span>Cambiar Contraseña</span>
            </a>
        </li>
    <?php endif; ?>


    <hr class="sidebar-divider">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
