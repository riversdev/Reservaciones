<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservaciones</title>
  <!-- BOOTSTRAP 4.5.0 -->
  <link rel="stylesheet" href="static/bootstrap/css/bootstrap.css">
  <script src="static/js/jquery-3.5.1.js"></script>
  <script src="static/fullcalendar/js/moment.min.js"></script>
  <script src="static/bootstrap/js/bootstrap.js"></script>
  <!--<script src="static/js/popper.min.js"></script>-->
  <!-- ALERTIFY 1.13.1 -->
  <link rel="stylesheet" href="static/alertify/css/alertify.css">
  <link rel="stylesheet" href="static/alertify/css/themes/default.min.css">
  <script src="static/alertify/alertify.js"></script>
  <!-- FONTAWESOME-FREE-5.13.0-web -->
  <link rel="stylesheet" href="static/fontawesome/css/all.css">
  <script src="static/fontawesome/js/all.js"></script>
  <!-- FULLCALLENDAR -->
  <link rel="stylesheet" href="static/fullcalendar/css/fullcalendar.css">
  <script src="static/fullcalendar/js/fullcalendar.js"></script>
  <script src="static/fullcalendar/js/es.js"></script>
  <!-- CLOCKPICKER -->
  <link rel="stylesheet" href="static/clockpicker/bootstrap-clockpicker.css">
  <script src="static/clockpicker/bootstrap-clockpicker.js"></script>
  <!-- CUSTOM JS -->
  <script src="static/js/main.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="mr-auto"></div>
      <nav class="navbar-nav my-2 my-lg-0">
        <div class="nav" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-petitions-tab" data-toggle="tab" href="#nav-petitions" role="tab" aria-controls="nav-petitions" aria-selected="true">Peticiones</a>
          <a class="nav-item nav-link" id="nav-citas-tab" data-toggle="tab" href="#nav-citas" role="tab" aria-controls="nav-citas" aria-selected="false">Citas</a>
        </div>
      </nav>
    </div>
  </nav>

  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-petitions" role="tabpanel" aria-labelledby="nav-petitions-tab">
      <div class="container">
        <div class="row justify-content-center pt-5">
          <div class="card mb-3" style="width: 80%;">
            <div class="row no-gutters bordeNormal">
              <div class="card-body">
                <div class="row align-items-center text-center">
                  <div class="col-5">
                    <i class="far fa-9x fa-calendar-check"></i>
                  </div>
                  <div class="col-6" style="border-right: 5px solid #343a40;">
                    <h3 class="card-title">¿Necesitas agendar una cita?</h3>
                    <p class="card-text"><small class="text-muted">Ingresa tus datos de contacto y te haremos saber la fecha de reunión.</small></p>
                  </div>
                </div>
                <form id="formAppointment" class="needs-validation pt-4" novalidate>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="txtName">Nombre</label>
                      <input type="text" class="form-control" id="txtName" placeholder="Juan Pérez Gonzáles" required>
                      <div class="valid-feedback">
                        Correcto!
                      </div>
                      <div class="invalid-feedback">
                        Ingresa tu nombre.
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="txtEmail">Email</label>
                      <input type="email" class="form-control" id="txtEmail" placeholder="email@mail.com" required>
                      <div class="valid-feedback">
                        Correcto!
                      </div>
                      <div class="invalid-feedback">
                        Ingresa tu correo.
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="txtNumber">Teléfono</label>
                      <input type="tel" class="form-control" id="txtNumber" placeholder="7770001234" pattern="[0-9]{10,15}" required>
                      <div class="valid-feedback">
                        Correcto!
                      </div>
                      <div class="invalid-feedback">
                        Ingresa tu número telefónico.
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-12 mb-3">
                      <label for="txtIssue">Asunto</label>
                      <textarea class="form-control" id="txtIssue" cols="30" rows="5" placeholder="Ingresa un asunto para esta cita..." required></textarea>
                      <div class="valid-feedback">
                        Correcto!
                      </div>
                      <div class="invalid-feedback">
                        Ingresa un asunto para esta cita.
                      </div>
                    </div>
                  </div>
                  <div class="text-right">
                    <button class="btn btn-outline-dark" type="submit">Agendar</button>
                  </div>
                  <div id="res"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade active" id="nav-citas" role="tabpanel" aria-labelledby="nav-citas-tab">
      <div class="p-3">
        <div class="row justify-content-center" style="height:85vh;">
          <div class="col-3">
            <div id="petitionsList" class="list-group list-group-flush" style="font-size: small;"></div>
          </div>
          <div class="col-9">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL DE EVENTOS -->
  <div class="modal fade" id="modalEvents" tabindex="-1" role="dialog" aria-labelledby="eventsModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bordeNormal" id="headerModal">
          <h5 class="modal-title" id="eventsModalTitle">Agendar cita</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formEvents" class="needs-validation" novalidate>
            <input type="hidden" id="eventForId">
            <div class="form-row">
              <div class="col-md-6 offset-3 mb-3">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Fecha</div>
                  </div>
                  <input type="date" class="form-control" id="eventForDate" value="" required>
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
                      <input type="time" class="form-control" id="eventForHourStart" min="08:00" max="20:00" value="" required>
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
                      <input type="time" class="form-control" id="eventForHourEnd" min="08:00" max="20:00" value="" required>
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
                    <hr>
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
                      <input type="text" class="form-control" id="eventForName" placeholder="Juan Pérez Gonzáles" value="" required>
                      <div class="valid-feedback">
                        Correcto!
                      </div>
                      <div class="invalid-feedback">
                        Ingresa tu nombre.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7 mb-3">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Email</div>
                  </div>
                  <input type="email" class="form-control" id="eventForEmail" placeholder="email@mail.com" value="" required>
                  <div class="valid-feedback">
                    Correcto!
                  </div>
                  <div class="invalid-feedback">
                    Ingresa tu correo.
                  </div>
                </div>
              </div>
              <div class="col-md-5 mb-3">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Teléfono</div>
                  </div>
                  <input type="tel" class="form-control" id="eventForTel" placeholder="7770001234" value="" pattern="[0-9]{10,15}" required>
                  <div class="valid-feedback">
                    Correcto!
                  </div>
                  <div class="invalid-feedback">
                    Ingresa tu número telefónico.
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-12 mb-3" id="rowIssue">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Asunto</div>
                  </div>
                  <textarea class="form-control" id="eventForIssue" placeholder="Ingresa un asunto para esta cita..." cols="30" rows="3" required></textarea>
                  <div class="valid-feedback">
                    Correcto!
                  </div>
                  <div class="invalid-feedback">
                    Ingresa un asunto para esta cita.
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" id="eventForStatus">
            <div id="btnsEvents" class="text-right">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Salir</button>
              <button type="button" class="btn btn-sm btn-outline-warning d-none" id="btnEventCancel">Cancelar</button>
              <button type="button" class="btn btn-sm btn-outline-info d-none" id="btnEventEdit">Editar</button>
              <button type="button" class="btn btn-sm btn-outline-danger d-none" id="btnEventDelete">Eliminar</button>
              <button type="submit" class="btn btn-sm btn-outline-dark d-none" id="btnEventAgendar">Agendar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>

<script>
  // Inicio de JavaScript para deshabilitar los envíos de formularios si hay campos no válidos
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Obtener todos los formularios a los que se quiere aplicar estilos personalizados de validación Bootstrap
      var forms = document.getElementsByClassName('needs-validation');
      // Bucle sobre los formularios y evitar el envio o enviar datos
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          } else {
            event.preventDefault();
            if (form.id == "formAppointment") {
              let name = document.getElementById("txtName").value;
              let email = document.getElementById("txtEmail").value;
              let number = document.getElementById("txtNumber").value;
              let issue = document.getElementById("txtIssue").value;
              guardarPeticion(name, email, number, issue);
            }
            if (form.id == "formEvents") {
              if (form[8].value == "agendar") {
                $('#modalEvents').modal('hide');
                enviarInformacion('agendada', obtenerDatosGUI()); /////// fucking instruction !!!!!!!!
              }
              if (form[8].value == "editar") {
                $('#modalEvents').modal('hide');
                enviarInformacion('actualizada', obtenerDatosGUI()); /////// fucking instruction !!!!!!!!
              }
            }
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  $(".clockpicker").clockpicker();

  // CALENDARIO
  $(document).ready(function() {
    $('#calendar').fullCalendar({
      eventLimit: true,
      header: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'month,basicWeek,basicDay, listWeek',
      },
      dayClick: function(date, jsEvent, view) {
        $("#eventsModalTitle").html("Agendar cita").removeClass("text-info").addClass("text-dark");
        $('#eventForDate').removeAttr("disabled");
        $('#eventForHourStart').removeAttr("disabled");
        $('#eventForHourEnd').removeAttr("disabled");
        $('#eventForName').removeAttr("disabled");
        $('#eventForEmail').removeAttr("disabled");
        $('#eventForTel').removeAttr("disabled");
        $('#eventForIssue').removeAttr("disabled");
        $("#btnEventCancel").addClass("d-none");
        $("#btnEventEdit").addClass("d-none");
        $("#btnEventDelete").addClass("d-none");
        $("#btnEventAgendar").removeClass("d-none");
        document.getElementById("formEvents").reset();
        $('#eventForDate').val(date.format());
        $('#eventForHourStart').val("00:00");
        $('#eventForHourEnd').val("00:00");
        $("#eventForStatus").val("agendar");
        $("#rowIssue").removeClass("d-none");
        $("#headerModal").removeClass("bordeEdit").addClass("bordeNormal");
        $('#modalEvents').modal();
      },
      events: 'templates/crudCalendario.php',
      eventClick: function(calEvent, jsEvent, view) {
        $("#eventsModalTitle").html(calEvent.title).removeClass("text-info").addClass("text-dark");
        $('#eventForId').val(calEvent.idCita);
        $('#eventForDate').val(calEvent.fecha).attr("disabled", "true");
        $('#eventForHourStart').val(calEvent.horaInicio).attr("disabled", "true");
        $('#eventForHourEnd').val(calEvent.horaFin).attr("disabled", "true");
        $('#eventForName').val(calEvent.nombre).attr("disabled", "true");
        $('#eventForEmail').val(calEvent.email).attr("disabled", "true");
        $('#eventForTel').val(calEvent.tel).attr("disabled", "true");
        $('#eventForIssue').val(calEvent.asunto).attr("disabled", "true");
        $("#btnEventCancel").addClass("d-none");
        $("#btnEventEdit").removeClass("d-none");
        $("#btnEventDelete").removeClass("d-none");
        $("#btnEventAgendar").addClass("d-none");
        $("#eventForStatus").val("editar");
        $("#rowIssue").addClass("d-none");
        $("#headerModal").removeClass("bordeEdit").addClass("bordeNormal");
        $('#modalEvents').modal();
      },
      editable: true,
      eventDrop: function(calEvent) {
        $('#eventForId').val(calEvent.idCita);
        $('#eventForDate').val(calEvent.start.format().split("T")[0]);
        $('#eventForHourStart').val(calEvent.start.format().split("T")[1]);
        $('#eventForHourEnd').val(calEvent.end.format().split("T")[1]);
        $('#eventForName').val(calEvent.nombre);
        $('#eventForEmail').val(calEvent.email);
        $('#eventForTel').val(calEvent.tel);
        $('#eventForIssue').val(calEvent.asunto);
        enviarInformacion('actualizada', obtenerDatosGUI());
      },
    });
  });
</script>

<style>
  .bordeNormal {
    border-top: 8px solid #343a40;
  }

  .bordeEdit {
    border-top: 8px solid #17a2b8;
  }
</style>