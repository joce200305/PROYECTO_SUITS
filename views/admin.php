<?php
// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("location:login");
    exit();
}
?>
<link rel="stylesheet" href="<?=CSS.'Admin.css'?>">

<div class="container mt-4">
    <div class="row justify-content-center ">
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <div class="col-12 col-md-10 col-lg-8 text-center mt-4">
            <h2>Lista de alumnos</h2>
        </div>
        <div class="col-10 text-end mt-3 table-responsive ">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">Añadir alumno</button>
            <table id="myTable" class="display table text-white">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Matrícula</th>
                        <th scope="col">Semestre</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="contenido_alumno">
                </tbody>
            </table>
        </div>
        <div class="col-10 text-end">
            <hr class="text-primary">
        </div>
    </div>
</div>

<!-- Modal para editar alumno -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" hidden id="id_alumno_act">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_nombre" name="edit_nombre" type="text" placeholder="Nombre">
                            <label class="text-primary" for="nombre"><i class="fa-solid fa-envelope me-2"></i>Nombre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_apellido" name="edit_apellido" type="text" placeholder="Apellido">
                            <label class="text-primary" for="apellido"><i class="fa-solid fa-envelope me-2"></i>Apellido</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_fecha_nacimiento" name="edit_fecha_nacimiento" type="date" placeholder="Fecha de nacimiento">
                            <label class="text-primary" for="fecha_nacimiento"><i class="fa-solid fa-envelope me-2"></i>Fecha de Nacimiento</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_matricula" name="edit_matricula" type="text" placeholder="Matrícula">
                            <label class="text-primary" for="matricula"><i class="fa-solid fa-envelope me-2"></i>Matrícula</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_semestre" name="edit_semestre" type="text" placeholder="Semestre">
                            <label class="text-primary" for="semestre"><i class="fa-solid fa-envelope me-2"></i>Semestre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="edit_carrera" name="edit_carrera" type="text" placeholder="Carrera">
                            <label class="text-primary" for="carrera"><i class="fa-solid fa-envelope me-2"></i>Carrera</label>
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

<!-- Modal para agregar alumno -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre">
                            <label class="text-primary" for="nombre"><i class="fa-solid fa-envelope me-2"></i>Nombre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="apellido" name="apellido" type="text" placeholder="Apellido">
                            <label class="text-primary" for="apellido"><i class="fa-solid fa-envelope me-2"></i>Apellido</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" type="date" placeholder="Fecha de nacimiento">
                            <label class="text-primary" for="fecha_nacimiento"><i class="fa-solid fa-envelope me-2"></i>Fecha de Nacimiento</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="matricula" name="matricula" type="text" placeholder="Matrícula">
                            <label class="text-primary" for="matricula"><i class="fa-solid fa-envelope me-2"></i>Matrícula</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="semestre" name="semestre" type="text" placeholder="Semestre">
                            <label class="text-primary" for="semestre"><i class="fa-solid fa-envelope me-2"></i>Semestre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="carrera" name="carrera" type="text" placeholder="Carrera">
                            <label class="text-primary" for="carrera"><i class="fa-solid fa-envelope me-2"></i>Carrera</label>
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
<script src="./public/js/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>