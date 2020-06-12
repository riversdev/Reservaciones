<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservaciones</title>
  <!-- jQuery y Popper -->
  <script src="static/bootstrap/jquery-3.5.1.slim.min.js"></script>
  <script src="static/bootstrap/popper.min.js"></script>
  <!-- BOOTSTRAP 4.5.0 -->
  <link rel="stylesheet" href="static/bootstrap/css/bootstrap.css">
  <script src="static/bootstrap/js/bootstrap.js"></script>
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
            <form class="needs-validation pt-4" novalidate>
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
            </form>

            <script>
              // Example starter JavaScript for disabling form submissions if there are invalid fields
              (function() {
                'use strict';
                window.addEventListener('load', function() {
                  // Fetch all the forms we want to apply custom Bootstrap validation styles to
                  var forms = document.getElementsByClassName('needs-validation');
                  // Loop over them and prevent submission
                  var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                      if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                      } else {
                        event.preventDefault();
                        guardarCita();
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

</body>

</html>