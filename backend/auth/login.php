<?php
// backend/auth/login.php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $args = [
        $email
    ];

    $conexion = conexion();
    $sentence = $conexion->prepare("SELECT * FROM users WHERE email = ?");
    $sentence->execute($args);

    $result = $sentence->get_result();
    if($result->num_rows === 1){
        $result_array = $result->fetch_array();
        $hashedPassword = $result_array['password'];
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $result_array['role'];
            $ttime = microtime(true)*1000;
            $_SESSION['token'] = $result_array['nombre'].$ttime;
            $_SESSION['id_user'] = $result_array['id'];
            if($result_array['role']==="cliente"){
                header('Location: /views/client/videos.php');
            }else{
                header('Location: /views/admin/dashboard.php');
            }
            exit();
        } else {
            echo "Usuario o Contraseña incorrectos. <a href='/'>Login nuevamente</a>";
        }
    }else{
        echo "Usuario o Contraseña incorrectos. <a href='/'>Login nuevamente</a>";
    }

}
?>
