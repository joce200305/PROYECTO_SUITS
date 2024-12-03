<?php
require_once '../config/conexion.php';
session_start();

class Login extends Conexion
{
    private function crear_sesion($usuario, $rol)
    {
        $_SESSION['usuario'] = [
            'usuario' => $usuario,
            'rol' => $rol
        ];
    }

    public function cerrar_sesion()
    {
        session_unset();
        session_destroy();
        echo json_encode([1, "Sesión finalizada!"]);
    }

    public function iniciar_sesion()
    {
        if (empty($_POST['usuario']) || empty($_POST['password'])) {
            echo json_encode([0, "Todos los campos son obligatorios."]);
            return;
        }

        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        $consulta = $this->obtener_conexion()->prepare(
            "SELECT u.*, r.descripcion AS rol
         FROM usuarios u
         JOIN rol r ON u.id_rol = r.id_roles
         WHERE u.usuario = :usuario"
        );
        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($datos) {
            // Comparar contraseña ingresada con la almacenada usando password_verify
            if (password_verify($password, $datos['password'])) {
                $this->crear_sesion($datos['usuario'], $datos['rol']);
                if ($datos['rol'] == "admin") {
                    echo json_encode([1, "Sesión iniciada como administrador", "admin"]);
                } elseif ($datos['rol'] == "alumno") {
                    echo json_encode([1, "Sesión iniciada como alumno", "alumno"]);
                } else {
                    echo json_encode([0, "Rol no reconocido"]);
                }
            } else {
                echo json_encode([0, "Contraseña incorrecta"]);
            }
        } else {
            echo json_encode([0, "Usuario no encontrado"]);
        }
    }
}

$login = new Login();
$metodo = $_POST['metodo'];
$login->$metodo();
