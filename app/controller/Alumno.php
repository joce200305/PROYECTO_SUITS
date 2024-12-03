<?php
require_once '../config/conexion.php';

class Alumno extends Conexion {

    public function obtener_datos() {
        $consulta = $this->obtener_conexion()->prepare(
            "SELECT 
                calificaciones.id_calificacion, 
                alumnos.nombre AS alumno, 
                materias.nombre_materia AS materia, 
                profesores.nombre AS profesor, 
                calificaciones.calificacion, 
                calificaciones.fecha
            FROM calificaciones
            LEFT JOIN alumnos ON calificaciones.id_alumno = alumnos.id_alumno
            LEFT JOIN materias ON calificaciones.id_materia = materias.id_materia
            LEFT JOIN profesores ON materias.id_profesor = profesores.id_profesor"
        );

        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }
}

$consulta = new Alumno();
$metodo = $_POST['metodo'];
$consulta->$metodo();
?>
