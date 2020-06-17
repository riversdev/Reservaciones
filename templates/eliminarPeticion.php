<?php
require_once "conexion.php";
$idPeticion = $_POST['idPeticion'];
# ELIMINANDO PETICION
$SQL = "DELETE FROM peticiones WHERE idPeticion=$idPeticion;";
$stmt = Conexion::conectar()->prepare($SQL);
$stmt->execute();
?>