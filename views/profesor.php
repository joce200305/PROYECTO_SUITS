<?php
// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("location:login");
    exit();
}
?>
<link rel="stylesheet" href="<?=CSS.'profesores.css'?>">


<div class="container mt-4">
    <div class="row justify-content-center bg-card">
        <div class="col-10 text-center mt-4">
            <h2>Lista de profesores</h2>
        </div>
        <div class="col-10 text-end mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">Añadir profesor
            </button>
            <table id="myTable" class="display table text-white table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="contenido_profesor">
                </tbody>
            </table>
        </div>
        <div class="col-10 text-end">
            <hr class="text-primary">
        </div>
    </div>
</div>

<!-- Modal para Editar Profesor -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar profesor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" hidden id="id_profesor_act">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_nombre" name="edit_nombre" type="text" placeholder="Nombre">
                            <label class="text-primary" for="nombre"><i class="fa-solid fa-user me-2"></i>Nombre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_apellido" name="edit_apellido" type="text" placeholder="Apellido">
                            <label class="text-primary" for="apellido"><i class="fa-solid fa-user me-2"></i>Apellido</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_horario" name="edit_horario" type="time" placeholder="Horario">
                            <label class="text-primary" for="horario"><i class="fa-solid fa-clock me-2"></i>Horario</label>
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

<!-- Modal para Agregar Profesor -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar profesor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre">
                            <label class="text-primary" for="nombre"><i class="fa-solid fa-user me-2"></i>Nombre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="apellido" name="apellido" type="text" placeholder="Apellido">
                            <label class="text-primary" for="apellido"><i class="fa-solid fa-user me-2"></i>Apellido</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="horario" name="horario" type="time" placeholder="Horario">
                            <label class="text-primary" for="horario"><i class="fa-solid fa-clock me-2"></i>Horario</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_agregar">Añadir</button>
            </div>
        </div>
    </div>
</div>
<script src="./public/js/profesores.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

