<?php
require_once "conexion.php";

$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];
$issue = $_POST['issue'];

$marcaDeTiempo = date("Y-m-d H:i:s");

$SQL = "INSERT INTO peticiones (nombre, email, tel, asunto, marcaDeTiempo) 
        VALUES ('$name', '$email', $number, '$issue', '$marcaDeTiempo')";
$stmt = Conexion::conectar()->prepare($SQL);
$stmt->execute();
?>
