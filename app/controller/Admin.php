<?php
require_once '../config/conexion.php';

class Alumnos extends Conexion {

    public function obtener_datos() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM alumnos");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function insertar_datos() {
        if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['fecha_nacimiento']) || empty($_POST['matricula']) || empty($_POST['semestre']) || empty($_POST['carrera'])) {
            echo json_encode([0, "Todos los campos son obligatorios."]);
            return;
        }

        if (!is_numeric($_POST['matricula']) || !is_numeric($_POST['semestre'])) {
            echo json_encode([0, "La matrícula y el semestre deben ser números."]);
            return;
        }

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $matricula = $_POST['matricula'];
        $semestre = $_POST['semestre'];
        $carrera = $_POST['carrera'];

        $insercion = $this->obtener_conexion()->prepare("INSERT INTO alumnos (nombre, apellido, fecha_nacimiento, matricula, semestre, carrera) 
        VALUES (:nombre, :apellido, :fecha_nacimiento, :matricula, :semestre, :carrera)");
        $insercion->bindParam(':nombre', $nombre);
        $insercion->bindParam(':apellido', $apellido);
        $insercion->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $insercion->bindParam(':matricula', $matricula);
        $insercion->bindParam(':semestre', $semestre);
        $insercion->bindParam(':carrera', $carrera);
        $insercion->execute();

        if ($insercion) {
            echo json_encode([1, "Inserción correcta"]);
        } else {
            echo json_encode([0, "Inserción no realizada"]);
        }
    }

    public function actualizar_datos() {
        // Validaciones
        if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['fecha_nacimiento']) || empty($_POST['matricula']) || empty($_POST['semestre']) || empty($_POST['carrera'])) {
            echo json_encode([0, "Todos los campos son obligatorios."]);
            return;
        }

        if (!is_numeric($_POST['matricula']) || !is_numeric($_POST['semestre'])) {
            echo json_encode([0, "La matrícula y el semestre deben ser números."]);
            return;
        }

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $matricula = $_POST['matricula'];
        $semestre = $_POST['semestre'];
        $carrera = $_POST['carrera'];
        $id_alumno = $_POST['id_alumno'];

        $actualizacion = $this->obtener_conexion()->prepare("UPDATE alumnos SET nombre = :nombre, apellido = :apellido, fecha_nacimiento = :fecha_nacimiento, matricula = :matricula, semestre = :semestre, carrera = :carrera WHERE id_alumno = :id_alumno");
        $actualizacion->bindParam(':nombre', $nombre);
        $actualizacion->bindParam(':apellido', $apellido);
        $actualizacion->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $actualizacion->bindParam(':matricula', $matricula);
        $actualizacion->bindParam(':semestre', $semestre);
        $actualizacion->bindParam(':carrera', $carrera);
        $actualizacion->bindParam(':id_alumno', $id_alumno);

        if ($actualizacion->execute()) {
            echo json_encode([1, "Actualización correcta", $id_alumno]);
        } else {
            echo json_encode([0, "Actualización no realizada"]);
        }
    }

    public function eliminar_datos() {
        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM alumnos WHERE id_alumno = :id_alumno");
        $id_alumno = $_POST['id_alumno'];
        $eliminar->bindParam(':id_alumno', $id_alumno);
        $eliminar->execute();

        if ($eliminar) {
            echo json_encode([1, "Eliminación correcta"]);
        } else {
            echo json_encode([0, "Eliminación no realizada"]);
        }
    }

    public function precargar_datos() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM alumnos WHERE id_alumno = :id_alumno");
        $id_alumno = $_POST['id_alumno'];
        $consulta->bindParam("id_alumno", $id_alumno);
        $consulta->execute();
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);
        echo json_encode($datos);
    }
}

$consulta = new Alumnos();
$metodo = $_POST['metodo'];
$consulta->$metodo();
?>
