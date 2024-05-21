<?php
// Datos de conexión a la base de datos
function conexion(){
    $host = 'localhost';
    $usuario = 'usario_db';
    $contraseña = 'contrasenia_db';
    $base_datos = 'movie_store';
    $conexion = new mysqli($host, $usuario, $contraseña, $base_datos);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    return $conexion;
}

function execute_select_query($query_select){
    $conexion = conexion();
    $resultado_select = $conexion->query($query_select);
    if ($resultado_select->num_rows > 0) {
        return $resultado_select;
    } else {
        return [];
    }

    // Cerrar conexión
    $conexion->close();
}

function execute_insert_query($query_insert){
    $conexion = conexion();
    if ($conexion->query($query_insert) === TRUE) {
        return "Success registry";
    } else {
        echo "Error: " . $conexion->error;
    }

    // Cerrar conexión
    $conexion->close();

}

?>