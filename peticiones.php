<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservaciones</title>
  <!-- BOOTSTRAP 4.5.0 -->
  <link rel="stylesheet" href="static/bootstrap/css/bootstrap.css">
  <script src="static/js/jquery-3.5.1.js"></script>
  <script src="static/bootstrap/js/bootstrap.js"></script>
  <!--<script src="static/js/popper.min.js"></script>-->
  <!-- ALERTIFY 1.13.1 -->
  <link rel="stylesheet" href="static/alertify/css/alertify.css">
  <link rel="stylesheet" href="static/alertify/css/themes/default.min.css">
  <script src="static/alertify/alertify.js"></script>
  <!-- fontawesome-free-5.13.0-web -->
  <link rel="stylesheet" href="static/fontawesome/css/all.css">
  <script src="static/fontawesome/js/all.js"></script>
  <!-- CUSTOM JS -->
  <script src="static/js/main.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="mr-auto"></div>
      <nav class="navbar-nav my-2 my-lg-0">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link" id="nav-petitions-tab" data-toggle="tab" href="#nav-petitions" role="tab" aria-controls="nav-petitions" aria-selected="true">Peticiones</a>
          <a class="nav-item nav-link active" id="nav-citas-tab" data-toggle="tab" href="#nav-citas" role="tab" aria-controls="nav-citas" aria-selected="false">Citas</a>
        </div>
      </nav>
    </div>
  </nav>

  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade" id="nav-petitions" role="tabpanel" aria-labelledby="nav-petitions-tab">
      <div class="container">
        <div class="row justify-content-center pt-5">
          <div class="card mb-3" style="width: 80%;">
            <div class="row no-gutters">
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
                      <input type="tel" class="form-control" id="txtNumber" placeholder="7770001234" required pattern="[0-9]{10,15}">
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
                            let name = document.getElementById("txtName").value;
                            let email = document.getElementById("txtEmail").value;
                            let number = document.getElementById("txtNumber").value;
                            let issue = document.getElementById("txtIssue").value;
                            guardarPeticion(name, email, number, issue);
                          }
                          form.classList.add('was-validated');
                        }, false);
                      });
                    }, false);
                  })();
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade show active" id="nav-citas" role="tabpanel" aria-labelledby="nav-citas-tab">
      <div class="p-4">
        <div class="row justify-content-center">
          <div class="col-3 border">S</div>
          <div class="col-9 border">S</div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>