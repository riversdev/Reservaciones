<?php
require_once "conexion.php";

$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];
$issue = $_POST['issue'];

$fecha = date("Y-m-d");

$SQL = "INSERT INTO citas (nombre, email, tel, asunto, fecha) 
        VALUES ('$name', '$email', $number, '$issue', '$fecha')";
$stmt = Conexion::conectar()->prepare($SQL);
$stmt->execute();

echo '
<script>
    alert("Funciona !");
</script>
';
?>