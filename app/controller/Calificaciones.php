<?php
require_once '../config/conexion.php';

class Calificaciones extends Conexion
{

    public function obtener_datos()
    {
        $consulta = $this->obtener_conexion()->prepare("SELECT calificaciones.id_calificacion, 
       alumnos.nombre AS alumno, 
       materias.nombre_materia AS materia, 
       profesores.nombre AS profesor, 
       calificaciones.calificacion, 
       calificaciones.fecha
        FROM calificaciones
        LEFT JOIN alumnos ON calificaciones.id_alumno = alumnos.id_alumno
        LEFT JOIN materias ON calificaciones.id_materia = materias.id_materia
        LEFT JOIN profesores ON materias.id_profesor = profesores.id_profesor
        ");

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function precargar_datos()
    {
        if (empty($_POST['id_calificacion'])) {
            echo json_encode([0, "El id de la calificación es obligatorio."]);
            return;
        }

        $id_calificacion = $_POST['id_calificacion'];

        $consulta = $this->obtener_conexion()->prepare("SELECT calificacion, fecha, id_calificacion FROM calificaciones WHERE id_calificacion = :id_calificacion");
        $consulta->bindParam(':id_calificacion', $id_calificacion);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            echo json_encode($resultado);
        } else {
            echo json_encode([0, "No se encontraron datos para la calificación especificada."]);
        }
        $this->cerrar_conexion();
    }

    public function insertar_datos()
    {
        if (empty($_POST['id_alumno']) || empty($_POST['id_materia']) || empty($_POST['calificacion']) || empty($_POST['fecha'])) {
            echo json_encode([0, "Todos los campos son obligatorios."]);
            return;
        }

        if (!is_numeric($_POST['calificacion'])) {
            echo json_encode([0, "La calificación debe ser un número."]);
            return;
        }

        $id_alumno = $_POST['id_alumno'];
        $id_materia = $_POST['id_materia'];
        $calificacion = $_POST['calificacion'];
        $fecha = $_POST['fecha'];

        $insercion = $this->obtener_conexion()->prepare("INSERT INTO calificaciones (id_alumno, id_materia, calificacion, fecha) 
            VALUES (:id_alumno, :id_materia, :calificacion, :fecha)");
        $insercion->bindParam(':id_alumno', $id_alumno);
        $insercion->bindParam(':id_materia', $id_materia);
        $insercion->bindParam(':calificacion', $calificacion);
        $insercion->bindParam(':fecha', $fecha);

        if ($insercion->execute()) {
            echo json_encode([1, "Inserción correcta"]);
        } else {
            echo json_encode([0, "Inserción no realizada"]);
        }
        $this->cerrar_conexion();
    }



    public function actualizar_datos()
    {
        if (empty($_POST['calificacion']) || empty($_POST['fecha']) || empty($_POST['id_calificacion'])) {
            echo json_encode([0, "Todos los campos son obligatorios."]);
            return;
        }

        if (!is_numeric($_POST['calificacion'])) {
            echo json_encode([0, "La calificación debe ser un número."]);
            return;
        }

        $calificacion = $_POST['calificacion'];
        $fecha = $_POST['fecha'];
        $id_calificacion = $_POST['id_calificacion'];

        $actualizacion = $this->obtener_conexion()->prepare("UPDATE calificaciones 
            SET calificacion = :calificacion, fecha = :fecha 
            WHERE id_calificacion = :id_calificacion");
        $actualizacion->bindParam(':calificacion', $calificacion);
        $actualizacion->bindParam(':fecha', $fecha);
        $actualizacion->bindParam(':id_calificacion', $id_calificacion);

        if ($actualizacion->execute()) {
            echo json_encode([1, "Actualización correcta"]);
        } else {
            echo json_encode([0, "Actualización no realizada"]);
        }
        $this->cerrar_conexion();
    }

    public function eliminar_datos()
    {
        if (empty($_POST['id_calificacion'])) {
            echo json_encode([0, "El id de la calificación es obligatorio."]);
            return;
        }

        $id_calificacion = $_POST['id_calificacion'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM calificaciones 
            WHERE id_calificacion = :id_calificacion");
        $eliminar->bindParam(':id_calificacion', $id_calificacion);

        if ($eliminar->execute()) {
            echo json_encode([1, "Eliminación correcta"]);
        } else {
            echo json_encode([0, "Eliminación no realizada"]);
        }
        $this->cerrar_conexion();
    }

    public function obtener_alumnos()
    {
        $consulta = $this->obtener_conexion()->prepare("SELECT id_alumno, nombre, apellido FROM alumnos");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function obtener_materias()
    {
        $consulta = $this->obtener_conexion()->prepare("SELECT id_materia, nombre_materia FROM materias");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function obtener_profesor()
    {
        $consulta = $this->obtener_conexion()->prepare("SELECT id_profesor, nombre FROM profesores");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }
}

$consulta = new Calificaciones();
$metodo = $_POST['metodo'];
$consulta->$metodo();
