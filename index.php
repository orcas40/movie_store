<?php
session_start();
error_reporting(E_ERROR);

if (isset($_SESSION["token"])) {
    if(isset($_SESSION["role"]) && $_SESSION['role'] == "cliente"){
        echo("cliente antes de redireccionar");
        // Si el usuario está logueado, mostrar la página principal
        header('Location: /views/client/videos.php');
    } else {
        // Si el usuario no está logueado, mostrar el formulario de login
        include('views/auth/login.html');
    }
} else {
    // Si el usuario no está logueado, mostrar el formulario de login
    include('views/auth/login.html');
}
?>
