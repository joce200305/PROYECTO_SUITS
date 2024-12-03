<link rel="stylesheet" href="<?=CSS.'Nar.css'?>">

<nav class="navbar navbar-expand-lg">
  <div class="container text-center">
    <!-- Logo de la Navbar -->
    <a class="navbar-brand" href="<?=url('inicio');?>">
    <i class="fa-solid fa-school-flag"></i> ESCUELA
    </a>
    <!-- Botón de Menú en Pantalla Pequeña -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon text-white"></span>
    </button>
    
    <!-- Enlaces de Navegación -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav mx-auto mb-5 mb-lg-0">
        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
        <!-- Navbar para el Administrador -->
        <li class="nav-item">
          <a class="btn btn-nav" href="<?=url('admin');?>"><i class="fa-solid fa-users"></i></i>Alumnos</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-nav" href="<?=url('calificaciones');?>"><i class="fa-solid fa-chalkboard-teacher me-2"></i>Calificaciones</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-nav" href="<?=url('profesor');?>"><i class="fa-solid fa-users me-2"></i>Profesores</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-nav" href="<?=url('registro');?>"><i class="fa-solid fa-users me-2"></i>Registrar usuario</a>
        </li>
        <?php elseif (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno'): ?>
        <!-- Navbar para el Alumno -->
        <li class="nav-item">
          <a class="btn btn-nav" href="<?=url('alumno');?>"><i class="fa-solid fa-house me-2"></i>Inicio</a>
        </li>
        <?php else: ?>
        <!-- Opciones de login si no hay usuario autenticado -->
        <li class="nav-item">
          <a class="btn btn-nav" href="<?=url('login');?>"><i class="fa-solid fa-sign-in-alt me-2"></i>Iniciar Sesión</a>
        </li>
        <?php endif; ?>
      </ul>

      <!-- Menú Desplegable para Admin/Alumno -->
      <?php if (isset($_SESSION['usuario'])): ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto d-block">
        <li class="nav-item dropdown">
          <a class="btn btn-nav dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user me-2"></i>
            <?= $_SESSION['usuario']['usuario']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          
            <li><button type="button" class="btn btn-danger w-100" id="btn_cerrar"><i class="fa-solid fa-power-off me-2"></i>Cerrar sesión</button></li>
          </ul>
        </li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>