<?php
    require_once '../config/conexion.php';

    class Profesores extends Conexion {

        public function obtener_datos() {
            $consulta = $this->obtener_conexion()->prepare("SELECT * FROM profesores");
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $this->cerrar_conexion();
            echo json_encode($datos);
        }

        public function insertar_datos() {
            if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['horario'])) {
                echo json_encode([0, "Todos los campos son obligatorios."]);
                return;
            }

            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $horario = $_POST['horario'];

            $insercion = $this->obtener_conexion()->prepare("INSERT INTO profesores(nombre, apellido, horario) VALUES(:nombre, :apellido, :horario)");
            $insercion->bindParam(':nombre', $nombre);
            $insercion->bindParam(':apellido', $apellido);
            $insercion->bindParam(':horario', $horario);
            $insercion->execute();

            if ($insercion) {
                echo json_encode([1, "Inserción correcta"]);
            } else {
                echo json_encode([0, "Inserción no realizada"]);
            }
        }

        public function actualizar_datos() {
            // Validar que los campos no estén vacíos
            if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['horario'])) {
                echo json_encode([0, "Todos los campos son obligatorios."]);
                return;
            }

            // Obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $horario = $_POST['horario'];
            $id_profesor = $_POST['id_profesor'];

            // Actualizar los datos en la base de datos
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE profesores SET nombre = :nombre, apellido = :apellido, horario = :horario WHERE id_profesor = :id_profesor");
            $actualizacion->bindParam(':nombre', $nombre);
            $actualizacion->bindParam(':apellido', $apellido);
            $actualizacion->bindParam(':horario', $horario);
            $actualizacion->bindParam(':id_profesor', $id_profesor);

            // Devolver una respuesta
            if ($actualizacion->execute()) {
                echo json_encode([1, "Actualización correcta", $id_profesor]);
            } else {
                echo json_encode([0, "Actualización no realizada"]);
            }
        }

        public function eliminar_datos() {
            // Eliminar un profesor
            $eliminar = $this->obtener_conexion()->prepare("DELETE FROM profesores WHERE id_profesor = :id_profesor");
            $id_profesor = $_POST['id_profesor'];
            $eliminar->bindParam(':id_profesor', $id_profesor);
            $eliminar->execute();

            // Devolver una respuesta
            if ($eliminar) {
                echo json_encode([1, "Eliminación correcta"]);
            } else {
                echo json_encode([0, "Eliminación no realizada"]);
            }
        }

        public function precargar_datos() {
            // Consultar los datos de un profesor específico
            $consulta = $this->obtener_conexion()->prepare("SELECT * FROM profesores WHERE id_profesor = :id_profesor");
            $id_profesor = $_POST['id_profesor'];
            $consulta->bindParam("id_profesor", $id_profesor);
            $consulta->execute();
            $datos = $consulta->fetch(PDO::FETCH_ASSOC);
            echo json_encode($datos);
        }
    }

    // Crear una instancia y ejecutar el método correspondiente
    $consulta = new Profesores();
    $metodo = $_POST['metodo'];
    $consulta->$metodo();
?>
