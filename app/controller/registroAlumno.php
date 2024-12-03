<?php
require_once '../config/conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Registro extends Conexion
{
    // Insertar un nuevo alumno
    public function insertar_alumno()
    {
        if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['password'])) {
            echo json_encode([0, "Todos los campos son obligatorios."]);
            return;
        }

        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptamos la contraseña
        $id_rol = 2;  // Asegúrate de que este id exista en la tabla 'rol'

        try {
            // Verificar si el id_rol existe en la tabla 'rol'
            // Verificar si el usuario ya existe en la base de datos
            $consulta_usuario = $this->obtener_conexion()->prepare("SELECT COUNT(*) FROM usuarios WHERE LOWER(usuario) = LOWER(:usuario)");
            $consulta_usuario->bindParam(':usuario', $usuario);
            $consulta_usuario->execute();
            $usuario_existe = $consulta_usuario->fetchColumn();
            

            // Verificar si el usuario ya existe
            if ($usuario_existe > 0) {
                echo json_encode([0, "El usuario ya existe."]);
                return;
            }


            // Verificar si el usuario ya existe
            $consulta_usuario = $this->obtener_conexion()->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
            $consulta_usuario->bindParam(':usuario', $usuario);
            $consulta_usuario->execute();
            $usuario_existe = $consulta_usuario->fetchColumn();

            if ($usuario_existe > 0) {
                echo json_encode([0, "El usuario ya existe."]);
                return;
            }

            // Insertar el nuevo alumno
            $insercion = $this->obtener_conexion()->prepare("INSERT INTO usuarios (nombre, usuario, password, id_rol) VALUES(:nombre, :usuario, :password, :id_rol)");
            $insercion->bindParam(':nombre', $nombre);
            $insercion->bindParam(':usuario', $usuario);
            $insercion->bindParam(':password', $password);
            $insercion->bindParam(':id_rol', $id_rol);

            if ($insercion->execute()) {
                echo json_encode([1, "Alumno registrado correctamente"]);
            } else {
                echo json_encode([0, "No se pudo registrar el alumno"]);
            }
        } catch (Exception $e) {
            echo json_encode([0, "Error en la base de datos: " . $e->getMessage()]);
        }
    }
}

// Validar el método recibido
if (!isset($_POST['metodo'])) {
    echo json_encode([0, "Método no especificado"]);
    exit();
}

$registro = new Registro();

switch ($_POST['metodo']) {
    case 'insertar_alumno':
        $registro->insertar_alumno();
        break;
    default:
        echo json_encode([0, "Método no válido"]);
        break;
}
