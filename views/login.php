<?php
    if (isset($_SESSION['usuario'])) {
        if ($_SESSION['usuario']['rol'] === 'admin') {
            header("location:admin");
        } elseif ($_SESSION['usuario']['rol'] === 'alumno') {
            header("location:calificaciones");
        } else {
            header("location:inicio");
        }
        exit();
    }
?>
<link rel="stylesheet" href="<?= CSS.'Login.css' ?>">


<form id="frm_login" class="container">
    <div class="text-center">
        <h3>Iniciar Sesión</h3>
        <img src="public/img/logo.png" class="rounded-circle" width="40%" alt="Logo de Login">
    </div>
    <div class="form-floating my-3">
        <input class="form-control" id="usuario" name="usuario" type="text" placeholder="Usuario">
        <label for="usuario">Usuario</label>
    </div>
    <div class="form-floating my-3">
        <input id="password" name="password" type="password" class="form-control" placeholder="Contraseña">
        <label for="password">Contraseña</label>
    </div>
    <button class="btn w-100" type="button" id="btn_iniciar">Iniciar sesión</button>
    <a href="registroAlumno" class="btn-registro text-center mt-4">Registro</a>

</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./public/js/login.js"></script>
