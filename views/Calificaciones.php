<?php
// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("location:login");
    exit();
}

?>
<link rel="stylesheet" href="<?=CSS.'Calificaciones.css'?>">
<div class="container mt-4">
    <h2>Gestion de calificaciones</h2>
    <div class="text-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
            <i class="fa-solid fa-plus"></i> Agregar Calificación
        </button>
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="contenido_calificaciones">
            <!-- Contenido dinámico cargado con JavaScript -->
        </tbody>
    </table>
</div>

<!-- Modal para agregar calificación -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Agregar Calificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="id_alumno" class="form-label">Alumno</label>
                        <select id="id_alumno" class="form-select">
                            <option value="id_alumno">One</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_materia" class="form-label">Materia</label>
                        <select id="id_materia" class="form-select">
                            <option value="id_materia">One</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="calificacion" class="form-label">Calificación</label>
                        <input type="number" step="0.01" id="calificacion" class="form-control" placeholder="Ej. 9.5">
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" id="fecha" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_agregar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar calificación -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Calificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" hidden id="id_calificacion_act">
                        <div class="mb-3">
                            <label for="edit_calificacion" class="form-label">Calificación</label>
                            <input type="number" step="0.01" id="edit_calificacion" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="edit_fecha" class="form-label">Fecha</label>
                            <input type="date" id="edit_fecha" class="form-control">
                        </div>
                        
                    </div>
                </div>    

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_actualizar">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./public/js/calificaciones.js"></script>