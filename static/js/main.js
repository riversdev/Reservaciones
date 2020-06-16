$(document).ready(function () {
    let nuevoTiempo;
    // CONSULTAR PETICIONES PENDIENTES
    buscarPeticiones();

    // EVENTOS BOTONES
    $("#btnEventEdit").on('click', function () {
        $('#eventForDate').removeAttr("disabled");
        $('#eventForHourStart').removeAttr("disabled");
        $('#eventForHourEnd').removeAttr("disabled");
        $('#eventForName').removeAttr("disabled");
        $('#eventForEmail').removeAttr("disabled");
        $('#eventForTel').removeAttr("disabled");
        $('#eventForIssue').removeAttr("disabled");
        $("#btnEventCancel").removeClass("d-none");
        $("#btnEventEdit").addClass("d-none");
        $("#btnEventDelete").addClass("d-none");
        $("#btnEventAgendar").removeClass("d-none");
        $("#eventsModalTitle").html("EDITANDO CITA").removeClass("text-dark").addClass("text-info");
        $("#rowIssue").removeClass("d-none");
        $("#headerModal").removeClass("bordeNormal").addClass("bordeEdit");
    });
    $("#btnEventCancel").on('click', function () {
        $('#eventForDate').attr("disabled", "true");
        $('#eventForHourStart').attr("disabled", "true");
        $('#eventForHourEnd').attr("disabled", "true");
        $('#eventForName').attr("disabled", "true");
        $('#eventForEmail').attr("disabled", "true");
        $('#eventForTel').attr("disabled", "true");
        $('#eventForIssue').attr("disabled", "true");
        $("#btnEventCancel").addClass("d-none");
        $("#btnEventEdit").removeClass("d-none");
        $("#btnEventDelete").removeClass("d-none");
        $("#btnEventAgendar").addClass("d-none");
        $("#eventsModalTitle").html($('#eventForIssue').val()).removeClass("text-info").addClass("text-dark");
        $("#rowIssue").addClass("d-none");
        $("#headerModal").removeClass("bordeEdit").addClass("bordeNormal");
    });
    $("#btnEventDelete").on('click', function () {
        $("#modalEvents").modal('hide');
        let id = this.parentElement.parentElement[0].value;
        let name = this.parentElement.parentElement[4].value;
        let issue = this.parentElement.parentElement[7].value;
        alertify.confirm('Eliminando...', 'Seguro de que desea eliminar la cita de ' + name + ", para " + issue,
            function () {
                $("#modalEvents").modal('hide');
                enviarInformacion("eliminada", {
                    idPeticion: id, fecha: "", horaInicio: "", horaFin: "", nombre: "", email: "", telefono: "", asunto: ""
                });
            },
            function () {
                alertify.error('Cancelado !')
            });
    });

    // CAMBIO DE HORA MINIMO EN INPUT TIME DE HORA DE TERMINO
    $('#eventForHourEnd').on('click', function () {
        insertarHoraFinal("eventForHourStart", "eventForHourEnd");
    });

});

function insertarHoraFinal(start, end) {
    console.log(start + "," + end);

    let newTime = new Date('2000-01-01T' + $('#' + start).val());
    newTime.setMinutes(newTime.getMinutes() + 1);
    let horas = newTime.getHours();
    let minutos = newTime.getMinutes();
    if (horas < 10) {
        horas = '0' + horas;
    }
    if (minutos < 10) {
        minutos = '0' + minutos;
    }
    nuevoTiempo = horas + ':' + minutos;
    $('#' + end).attr("min", nuevoTiempo);
    console.log("Nuevo tiempo->" + nuevoTiempo);
}

async function buscarPeticiones() {
    $.ajax({
        type: "POST",
        url: "templates/buscarPeticiones.php",
        data: {},
        error: function (data) {
            console.error("Error peticion ajax para buscar peticiones");
        },
        success: function (data) {
            $("#petitionsList").empty();
            $("#petitionsList").append(data);
            console.log("Peticiones recuperadas exitosamente !")
        }
    });
}

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
            $("#res").empty();
            $("#res").append(data);
            alertify.alert('PETICIÓN ENVIADA !', 'En breve le haremos saber la fecha y hora de su cita madiante sus datos de contacto ingresados.');
            buscarPeticiones();
        }
    });
}

function obtenerDatosGUI() {
    return {
        idPeticion: $("#eventForId").val(),
        fecha: $("#eventForDate").val(),
        horaInicio: $("#eventForHourStart").val(),
        horaFin: $("#eventForHourEnd").val(),
        nombre: $("#eventForName").val(),
        email: $("#eventForEmail").val(),
        telefono: $("#eventForTel").val(),
        asunto: $("#eventForIssue").val()
    };
}

function enviarInformacion(accion, objCita) {
    $.ajax({
        type: "POST",
        url: "templates/crudCalendario.php?accion=" + accion,
        data: {
            idPeticion: objCita.idPeticion,
            fecha: objCita.fecha,
            horaInicio: objCita.horaInicio,
            horaFin: objCita.horaFin,
            nombre: objCita.nombre,
            email: objCita.email,
            telefono: objCita.telefono,
            asunto: objCita.asunto
        },
        error: function (data) {
            console.error("Error peticion ajax para enviar información, DETALLES: " + data);
        },
        success: function (data) {
            $("#calendar").fullCalendar('refetchEvents');
            buscarPeticiones();
            alertify.success("Cita " + accion + " exitosamente !");
        }
    });
}