<?php
require_once "conexion.php";

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';

switch ($accion) {
    case 'agendada':
        $idPeticion = $_POST['idPeticion'];
        $fecha = $_POST['fecha'];
        $horaInicio = $_POST['horaInicio'];
        $horaFin = $_POST['horaFin'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $asunto = $_POST['asunto'];
        # FECHAS DE INICIO Y TERMINO EN DATETIME PARA FULLCALENDAR
        $starts = $fecha . ' ' . $horaInicio;
        $ends = $fecha . ' ' . $horaFin;
        # AGREGANDO CITA
        $SQL = "INSERT INTO citas (title, start, end, fecha, horaInicio, horaFin, nombre, email, tel, asunto) 
        VALUES ('$asunto', '$starts', '$ends', '$fecha', '$horaInicio', '$horaFin', '$nombre', '$email', $telefono, '$asunto')";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        # ELIMINANDO PETICION DESPUES DE SER AGREGADA EN CITAS
        $SQL2 = "DELETE FROM peticiones WHERE idPeticion=$idPeticion;";
        $stmt2 = Conexion::conectar()->prepare($SQL2);
        $stmt2->execute();
        break;

    case 'eliminada':
        $idCita = $_POST['idPeticion'];
        # ELIMINANDO CITA
        $SQL = "DELETE FROM citas WHERE idCita=$idCita;";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        break;

    case 'actualizada':
        $idPeticion = $_POST['idPeticion'];
        $fecha = $_POST['fecha'];
        $horaInicio = $_POST['horaInicio'];
        $horaFin = $_POST['horaFin'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $asunto = $_POST['asunto'];
        # FECHAS DE INICIO Y TERMINO EN DATETIME PARA FULLCALENDAR
        $starts = $fecha . ' ' . $horaInicio;
        $ends = $fecha . ' ' . $horaFin;
        # ACTUALIZANDO CITA
        $SQL = "UPDATE citas 
                SET title='$asunto',
                    start='$starts',
                    end='$ends',
                    fecha='$fecha',
                    horaInicio='$horaInicio',
                    horaFin='$horaFin',
                    nombre='$nombre',
                    email='$email',
                    tel='$telefono',
                    asunto='$asunto'
                WHERE idCita=$idPeticion";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        break;

    default:
        $SQL = "SELECT * FROM citas";
        # MOSTRANDO CITAS
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
        break;
}
?>