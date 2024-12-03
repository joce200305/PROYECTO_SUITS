<?php
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
    header("location:login");
    exit();
}

?>
<link rel="stylesheet" href="<?= CSS.'nar.css' ?>">

<div class="container mt-5">
    <h1 class="text-center">Calificaciones</h1>
    <div class="text-end mb-3">
    </div>
    <table class="table table-bordered table-striped table-responsive" id="myTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Alumno</th>
                <th>Materia</th>
                <th>Profesor</th>
                <th>Calificación</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody id="contenido_calificaciones">
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./public/js/alumno.js"></script> 
