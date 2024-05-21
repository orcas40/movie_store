<?php
// Incluir el archivo init.php para obtener acceso a la conexión de la base de datos
require_once '../db.php';

try {
    // Verificar si se recibieron datos del formulario de registro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $password = $hashedPassword;
        $role = "cliente";

        $args = [
            $nombre,
            $email,
            $password,
            $role
        ];
        $conexion = conexion();
        $sentence = $conexion->prepare("INSERT INTO users (nombre, email, password, role) VALUES (?,?,?,?)");
        $result = $sentence->execute($args);

        if($result){
            echo "El usuario ha sido registrado exitosamente. Regresar a : <a href='/'>Login</a>";
        }else{
            echo "Ocurrio un error al registrar el usuario : <a href='../../views/auth/registry_user.html'>Registrar nuevamente</a>";
        }
    }
} catch (Exception $e) {
    echo "Ocurrio un error al registrar el usuario : ".$e." <br/><b><a href='../../views/auth/registry_user.html'>Registrar nuevamente</a></b>";
}
?>
