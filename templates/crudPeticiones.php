<?php
require_once "conexion.php";

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';

switch ($accion) {
    case 'guardada':
        $name = $_POST['name'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $issue = $_POST['issue'];
        # MARCA DE TIEMPO
        $marcaDeTiempo = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "- 1 days"));
        # GUARDANDO PETICION
        $SQL = "INSERT INTO peticiones (nombre, email, tel, asunto, marcaDeTiempo) 
        VALUES ('$name', '$email', '$number', '$issue', '$marcaDeTiempo')";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        break;

    case 'eliminada':
        $idPeticion = $_POST['idPeticion'];
        # ELIMINANDO PETICION
        $SQL = "DELETE FROM peticiones WHERE idPeticion=$idPeticion;";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        break;

    default:
        $SQL = "SELECT * FROM peticiones ORDER BY marcaDeTiempo DESC";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        echo '
            <div class="p-2">
                <div class="w-100 justify-content-between text-center">
                    <h2 class="mb-1">Peticiones</h2>
                </div>
            </div>
        ';
        if (count($resultado) == 0) {
            echo '
                <div class="alert alert-success" role="alert">
                    No existen peticiones pendientes !
                </div>
            ';
        } else {
            echo '
                <table id="tablaPeticiones" class="table table-hover" style="width: 100%">
                <thead class="d-none">
                    <tr>
                        <th scope="col">Peticiones</th>
                    </tr>
                </thead>
                <tbody class="pt-2">
            ';
            foreach ($resultado as $row) {
                echo '
                    <tr>
                    <td>
                    <a id="' . $row['idPeticion'] . '" data-toggle="modal" data-target="#modalPet' . $row['idPeticion'] . '">
                    <div class="d-flex w-100 justify-content-between">
                        <h7 class="mb-1 font-weight-bold">' . $row['nombre'] . '</h7>
                        <small class="text-muted">' . date("d-m-Y", strtotime($row['marcaDeTiempo'])) . '</small>
                    </div>
                    <p class="mb-1 text-justify" style="font-size:small;">' . substr($row['asunto'], 0, 80) . '...</p>
                    <small class="text-muted">' . $row['email'] . '</small>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="modalPet' . $row['idPeticion'] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row['idPeticion'] . 'modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header bordeNormal">
                                <h5 class="modal-title" id="' . $row['idPeticion'] . 'modalLabel">Agendar cita</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formAddAppointment' . $row['idPeticion'] . '" class="needs-validation" novalidate>
                                    <input class="d-none" value="' . $row['idPeticion'] . '">
                                    <div class="form-row">
                                        <div class="col-md-6 offset-3 mb-3">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text">Fecha</div>
                                            </div>
                                            <input type="date" class="form-control" id="txtDateAdd' . $row['idPeticion'] . '" min="' . date("Y-m-d", strtotime(date("Y-m-d") . "- 1 days")) . '" value="" required>
                                            <div class="valid-feedback">
                                            Correcto!
                                            </div>
                                            <div class="invalid-feedback">
                                            Ingresa la fecha de agenda.
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-md-5 offset-1">
                                            <div class="input-group input-group-sm clockpicker" data-autoclose="true">
                                                <div class="input-group-prepend">
                                                <div class="input-group-text">Inicio</div>
                                                </div>
                                                <input type="time" class="form-control" id="txtHourStartAdd' . $row['idPeticion'] . '" min="08:00" max="20:00" value="00:00" required>
                                                <div class="valid-feedback">
                                                Correcto!
                                                </div>
                                                <div class="invalid-feedback">
                                                Ingresa una hora de inicio válida.
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-5">
                                            <div class="input-group input-group-sm clockpicker" data-autoclose="true">
                                                <div class="input-group-prepend">
                                                <div class="input-group-text">Fin</div>
                                                </div>
                                                <input type="time" class="form-control" id="txtHourEndAdd' . $row['idPeticion'] . '" min="08:00" max="20:00" value="00:00" required>
                                                <div class="valid-feedback">
                                                Correcto!
                                                </div>
                                                <div class="invalid-feedback">
                                                Ingresa una hora de término válida.
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                        <div class="row">
                                            <div class="col-4">
                                            <hr class="bg-black">
                                            </div>
                                            <div class="col-4 text-center">
                                            <small class="text-muted">Datos de contacto</small>
                                            </div>
                                            <div class="col-4">
                                            <hr>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                        <div class="row">
                                            <div class="col-8 offset-2">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                <div class="input-group-text">Nombre</div>
                                                </div>
                                                <input type="text" class="form-control" id="txtNameAdd' . $row['idPeticion'] . '" value="' . $row['nombre'] . '" disabled>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text">Email</div>
                                            </div>
                                            <input type="email" class="form-control" id="txtEmailAdd' . $row['idPeticion'] . '" value="' . $row['email'] . '" disabled>
                                        </div>
                                        </div>
                                        <div class="col-md-5 mb-3">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text">Teléfono</div>
                                            </div>
                                            <input type="tel" class="form-control" id="txtNumberAdd' . $row['idPeticion'] . '" value="' . $row['tel'] . '" disabled>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 mb-3">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text">Asunto</div>
                                            </div>
                                            <textarea class="form-control" id="txtIssueAdd' . $row['idPeticion'] . '" cols="30" rows="3" disabled>' . $row['asunto'] . '</textarea>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Salir</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="btnEventDeletePET' . $row['idPeticion'] . '">Eliminar</button>
                                        <button class="btn btn-sm btn-outline-dark" type="submit">Agendar</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        $("#btnEventDeletePET' . $row['idPeticion'] . '").on("click", function () {
                            $("#modalPet' . $row['idPeticion'] . '").modal("hide");
                            let id = this.parentElement.parentElement[0].value;
                            let name = this.parentElement.parentElement[4].value;
                            let issue = this.parentElement.parentElement[7].value;
                            let email = this.parentElement.parentElement[5].value;
                            alertify.confirm("Eliminando...", "Seguro de que desea eliminar la cita de " + name + ", para " + issue,
                                function () {
                                    consultaPeticiones("eliminada", { idPeticion: id, nombre: "", email: email, telefono: "", asunto: "" });
                                },
                                function () {
                                    alertify.error("Cancelado !")
                                });
                        });
                        $("#txtHourEndAdd' . $row['idPeticion'] . '").on("click", function () {
                            insertarHoraFinal("txtHourStartAdd' . $row['idPeticion'] . '","txtHourEndAdd' . $row['idPeticion'] . '");
                        });
                        $("#txtHourStartAdd' . $row['idPeticion'] . '").on("click", function () {
                            insertarHoraInicial("txtHourStartAdd' . $row['idPeticion'] . '","txtDateAdd' . $row['idPeticion'] . '");
                        });
                    </script>
                    </td>
                    </tr>
                ';
            }
            echo '
                    </tbody>
                </table>
                <script>
                    var forms = document.getElementsByClassName("needs-validation");
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener("submit", function(event) {
                            let x = "txtHourStartAdd" + form[0].value;
                            let z = "txtDateAdd" + form[0].value;
                            insertarHoraInicial(x, z);
                            let i = "txtHourStartAdd" + form[0].value;
                            let f = "txtHourEndAdd" + form[0].value;
                            insertarHoraFinal(i, f);
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            } else {
                                event.preventDefault();
                                if(form.id=="formEvents"||form.id=="formAppointment"){}
                                else {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    } else {
                                        let objCita' . $row['idPeticion'] . ' = {
                                            idPeticion : form[0].value,
                                            fecha : form[1].value,
                                            horaInicio : form[2].value,
                                            horaFin : form[3].value,
                                            nombre : form[4].value,
                                            email : form[5].value,
                                            telefono : form[6].value,
                                            asunto : form[7].value
                                        };
                                        $("#modalPet" + form[0].value).modal("hide");
                                        enviarInformacion("agendada", objCita' . $row['idPeticion'] . ');
                                    }
                                }
                            }
                            form.classList.add("was-validated");
                        }, false);
                    });
                    $(".clockpicker").clockpicker();
                </script>
            ';
        }
        break;
}
?>