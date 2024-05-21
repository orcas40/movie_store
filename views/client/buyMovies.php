<?php
session_start();
require_once '../../backend/db.php';


$movieId = $_GET['movieId'] ? $_GET['movieId'] : '';
$id_user = $_SESSION['id_user'];

$args = [
    $id_user,
    $movieId
];

$conexion = conexion();
$sentence = $conexion->prepare("INSERT INTO purchases (user_id, movie_id) VALUES (?,?)");
$result = $sentence->execute($args);

if($result){
    header('Content-Type: application/json');
    $messages = [];
    $messages['Msg'] = 'Success';
    echo json_encode($messages);
}else{
    $messages['Msg'] = 'Error';
}

?>
