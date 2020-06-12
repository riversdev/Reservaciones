$(document).ready(function () {

});

function guardarPeticion(name, email, number, issue) {
    $.ajax({
        type: "POST",
        url: "templates/guardarPeticion.php",
        data: {
            name,
            email,
            number,
            issue
        },
        error: function (data) {
            console.error("Error peticion ajax para guardar la cita");
        },
        success: function (data) {
            //document.getElementById("formAppointment").reset();
            $("#res").empty();
            $("#res").append(data);
            alertify.alert('PETICIÓN ENVIADA !', 'En breve le haremos saber la fecha y hora de su cita madiante sus datos de contacto ingresados.');
        }
    });
}