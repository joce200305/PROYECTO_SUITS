<?php
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
  header("location:login");
  exit();
}


?>
<link rel="stylesheet" href="<?=CSS.'profesores.css'?>">
<div class="container my-4">
  <h1 class="text-center">USUARIOS</h1>

  <!-- Botón para abrir el modal de agregar usuario -->
  <div class="text-end my-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarModal">
      <i class="fa-solid fa-plus"></i> Agregar Usuario
    </button>
  </div>

  <!-- Cards para mostrar los usuarios -->
  <div class="row" id="contenido_usuarios">
    <!-- Los usuarios se cargarán aquí dinámicamente -->
  </div>
</div>

<!-- Modal Agregar Usuario -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="agregarModalLabel">Agregar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAgregar">
          <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Nombre</label>
            <input type="text" id="nombre_usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" id="usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select id="rol" class="form-control" required>
              <!-- Los roles se cargarán dinámicamente -->
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="btn_agregar" class="btn btn-success">Agregar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditar">
          <input type="hidden" id="id_usuario_act">
          <div class="mb-3">
            <label for="edit_nombre_usuario" class="form-label">Nombre</label>
            <input type="text" id="edit_nombre_usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_usuario" class="form-label">Usuario</label>
            <input type="text" id="edit_usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_password" class="form-label">Password</label>
            <input type="password" id="edit_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_rol" class="form-label">Rol</label>
            <select id="edit_rol" class="form-control" required>
              <!-- Los roles se cargarán dinámicamente -->
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="btn_actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </div>
  </div>
</div>
<!-- Agregar SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./public/js/registro.js"></script>