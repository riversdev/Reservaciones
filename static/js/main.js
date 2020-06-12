$(document).ready(function () {

});

function saveAppointment(name, email, number, issue) {
    $.ajax({
        type: "POST",
        url: "templates/saveAppointment.php",
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
            document.getElementById("formAppointment").reset();
            $("#res").empty();
            $("#res").append(data);
            alertify.success("Cita guardada exitosamente !");
        }
    });
}