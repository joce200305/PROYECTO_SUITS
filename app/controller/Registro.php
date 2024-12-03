<?php
require_once '../config/conexion.php';
// Al principio de tu archivo PHP, agrega esto para habilitar la visualización de errores:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Usuarios extends Conexion

{

    public function obtener_roles()
    {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM rol"); // Asegúrate de que 'roles' sea el nombre correcto de tu tabla
        $consulta->execute();
        $rol = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($rol);
    }

    // Obtener todos los usuarios
    // Obtener todos los usuarios con el nombre de rol
    public function obtener_datos()
    {
        $consulta = $this->obtener_conexion()->prepare(
            "SELECT usuarios.id_usuario, usuarios.nombre, usuarios.usuario, rol.descripcion as rol
         FROM usuarios 
         JOIN rol ON usuarios.id_rol = rol.id_roles" // Asegúrate de usar el nombre correcto de la tabla y columna
        );
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }



    // Insertar un nuevo usuario
    // Método para insertar datos
public function insertar_datos()
{
    // Verificar si los datos están vacíos
    if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['password']) || empty($_POST['id_rol'])) {
        echo json_encode([0, "Todos los campos son obligatorios."]);
        return;
    }

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptamos la contraseña
    $id_rol = $_POST['id_rol'];

    // Verificar si el usuario ya existe
    try {
        $consulta_usuario = $this->obtener_conexion()->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
        $consulta_usuario->bindParam(':usuario', $usuario);
        $consulta_usuario->execute();
        $usuario_existe = $consulta_usuario->fetchColumn();

        if ($usuario_existe > 0) {
            echo json_encode([0, "El usuario ya existe."]);
            return;
        }

        // Inserción del usuario
        $insercion = $this->obtener_conexion()->prepare("INSERT INTO usuarios (nombre, usuario, password, id_rol) VALUES(:nombre, :usuario, :password, :id_rol)");
        $insercion->bindParam(':nombre', $nombre);
        $insercion->bindParam(':usuario', $usuario);
        $insercion->bindParam(':password', $password);
        $insercion->bindParam(':id_rol', $id_rol);
        $insercion->execute();

        // Verifica si la inserción fue exitosa
        if ($insercion) {
            echo json_encode([1, "Inserción correcta"]);
        } else {
            echo json_encode([0, "Inserción no realizada"]);
        }
    } catch (Exception $e) {
        // Si hay un error en el bloque try, se captura y se devuelve un error JSON
        echo json_encode([0, "Error en la base de datos: " . $e->getMessage()]);
    }
}



    // Método para actualizar los datos
    public function actualizar_usuario()
    {
        if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['id_rol']) || empty($_POST['id_usuario'])) {
            echo json_encode([0, "Todos los campos son obligatorios."]);
            return;
        }

        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $id_rol = $_POST['id_rol'];
        $id_usuario = $_POST['id_usuario'];

        // Verificar que el id_rol existe en la tabla rol
        $consulta_rol = $this->obtener_conexion()->prepare("SELECT COUNT(*) FROM rol WHERE id_roles = :id_rol");
        $consulta_rol->bindParam(':id_rol', $id_rol);
        $consulta_rol->execute();
        $rol_existe = $consulta_rol->fetchColumn();

        if ($rol_existe == 0) {
            echo json_encode([0, "El rol seleccionado no existe."]);
            return;
        }

        // Solo actualizamos la contraseña si se proporciona
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE usuarios SET nombre = :nombre, usuario = :usuario, password = :password, id_rol = :id_rol WHERE id_usuario = :id_usuario");
            $actualizacion->bindParam(':password', $password);
        } else {
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE usuarios SET nombre = :nombre, usuario = :usuario, id_rol = :id_rol WHERE id_usuario = :id_usuario");
        }

        $actualizacion->bindParam(':nombre', $nombre);
        $actualizacion->bindParam(':usuario', $usuario);
        $actualizacion->bindParam(':id_rol', $id_rol);
        $actualizacion->bindParam(':id_usuario', $id_usuario);

        if ($actualizacion->execute()) {
            echo json_encode([1, "Actualización correcta", $id_usuario]);
        } else {
            echo json_encode([0, "Actualización no realizada"]);
        }
    }
    // Eliminar usuario
    public function eliminar_usuario()
    {
        if (empty($_POST['id_usuario'])) {
            echo json_encode([0, "ID de usuario no especificado"]);
            return;
        }

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
        $id_usuario = $_POST['id_usuario'];
        $eliminar->bindParam(':id_usuario', $id_usuario);
        $eliminar->execute();

        if ($eliminar) {
            echo json_encode([1, "Eliminación correcta"]);
        } else {
            echo json_encode([0, "Eliminación no realizada"]);
        }
    }



    // Precargar datos de un usuario
    public function precargar_datos()
    {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
        $id_usuario = $_POST['id_usuario'];
        $consulta->bindParam("id_usuario", $id_usuario);
        $consulta->execute();
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);
        echo json_encode($datos);
    }

}// Validar el método recibido
if (!isset($_POST['metodo'])) {
    echo json_encode([0, "Método no especificado"]);
    exit();
}

$usuarios = new Usuarios();

switch ($_POST['metodo']) {
    case 'obtenerRoles':
        $usuarios->obtener_roles();
        break;
    case 'obtener_datos':
        $usuarios->obtener_datos();
        break;
    case 'insertar_datos':
        $usuarios->insertar_datos();
        break;
    case 'actualizar_usuario':
        $usuarios->actualizar_usuario();
        break;
    case 'eliminar_usuario':
        $usuarios->eliminar_usuario();
        break;
    default:
        echo json_encode([0, "Método no válido"]);
        break;
}
