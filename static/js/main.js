$(document).ready(function () {
    // CONSULTAR PETICIONES PENDIENTES
    consultaPeticiones("leer", { idPeticion: "", nombre: "", email: "", telefono: "", asunto: "" });

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
        $('#eventForDate').attr("min", fechaActual);
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
        let email = this.parentElement.parentElement[5].value;
        alertify.confirm('Eliminando...', 'Seguro de que desea eliminar la cita de ' + name + ", para " + issue,
            function () {
                $("#modalEvents").modal('hide');
                enviarInformacion("eliminada", {
                    idPeticion: id, fecha: "", horaInicio: "", horaFin: "", nombre: "", email: email, telefono: "", asunto: ""
                });
            },
            function () {
                alertify.error('Cancelado !')
            });
    });

    // CAMBIO DE HORA MINIMO EN INPUT TIME DE HORA DE INICIO
    $('#eventForHourStart').on('click', function () {
        insertarHoraInicial("eventForHourStart", "eventForDate");
    });

    // CAMBIO DE HORA MINIMO EN INPUT TIME DE HORA DE TERMINO
    $('#eventForHourEnd').on('click', function () {
        insertarHoraFinal("eventForHourStart", "eventForHourEnd");
    });

});

function insertarHoraInicial(start, fecha) {
    // FECHA ACTUAL RECUPERADA CON JS
    let fechaActual = new Date();
    let anio = fechaActual.getFullYear();
    let mes = fechaActual.getMonth() + 1;
    let dia = fechaActual.getDate();
    mes < 10 ? mes = '0' + mes : mes = mes;
    dia < 10 ? dia = '0' + dia : dia = dia;
    let cadFechaActual = anio + '-' + mes + '-' + dia;

    // RECUPERACION DE FECHA SELECCIONADA
    let fechaSeleccionada = new Date($('#' + fecha).val());
    fechaSeleccionada.setDate(fechaSeleccionada.getDate() + 1);
    let anioFS = fechaSeleccionada.getFullYear();
    let mesFS = fechaSeleccionada.getMonth() + 1;
    let diaFS = fechaSeleccionada.getDate();
    mesFS < 10 ? mesFS = '0' + mesFS : mesFS = mesFS;
    diaFS < 10 ? diaFS = '0' + diaFS : diaFS = diaFS;
    let cadFechaSeleccionada = anioFS + '-' + mesFS + '-' + diaFS;

    // SI LA FECHA ACTUAL ES LA MISMA QUE LA SELECCIONADA SE ESTABLECE LA HORA ACTUAL COMO LA MINIMA
    if (cadFechaSeleccionada == cadFechaActual) {
        let horas = fechaActual.getHours();
        let minutos = fechaActual.getMinutes();
        horas < 10 ? horas = '0' + horas : horas = horas;
        minutos < 10 ? minutos = '0' + minutos : minutos = minutos;
        $('#' + start).attr("min", horas + ':' + minutos);
        console.log("1->" + $('#' + start).attr("min"));
    } else {
        $('#' + start).attr("min", '08:00');
        console.log("2->" + $('#' + start).attr("min"));
    }
}

function insertarHoraFinal(start, end) {
    let newTime = new Date('2000-01-01T' + $('#' + start).val());
    newTime.setMinutes(newTime.getMinutes() + 1);
    let horas = newTime.getHours();
    let minutos = newTime.getMinutes();
    horas < 10 ? horas = '0' + horas : horas = horas;
    minutos < 10 ? minutos = '0' + minutos : minutos = minutos;
    $('#' + end).attr("min", horas + ':' + minutos);
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
            consultaPeticiones("leer", { idPeticion: "", nombre: "", email: "", telefono: "", asunto: "" });
            alertify.success("Cita " + accion + " exitosamente !");
        }
    });
    if (accion == "eliminada") {
        // ENVIO DEL CORREO
        Email.send({
            //SecureToken :"",
            Host: "smtp.gmail.com",
            Username: "secretariaTecXD@gmail.com",
            Password: "1q2w3e4r5t?",
            To: objCita.email,
            From: "secretariaTecXD@gmail.com",
            Subject: "Su cita ha sido cancelada.",
            Body: "<b>Por este medio le informamos que su cita ha sido cancelada.</b>"
        }).then(function (message) {
            alertify.success("El interesado ha sido notificado !");
        }, function (message) {
            alertify.success("Imposible notificar al interesado !");
            console.log(message);
        }
        );
    }
    else {
        // CUERPO DEL CORREO
        let cuerpoDelCorreo = "<b>Por este medio le proporcionamos los datos referentes a su próxima cita.</b>" +
            "<br> <b>Fecha:</b> " + objCita.fecha +
            "<br> <b>Hora de inicio:</b> " + objCita.horaInicio +
            "<br> <b>Hora de término: </b>" + objCita.horaFin +
            "<br> <b>Asunto: </b>" + objCita.asunto +
            "<br> <b>Un cordial saludo. Le esperamos.</b>";
        // ENVIO DEL CORREO
        Email.send({
            //SecureToken :"",
            Host: "smtp.gmail.com",
            Username: "secretariaTecXD@gmail.com",
            Password: "1q2w3e4r5t?",
            To: objCita.email,
            From: "secretariaTecXD@gmail.com",
            Subject: "Su cita ha sido " + accion + ".",
            Body: cuerpoDelCorreo
        }).then(function (message) {
            alertify.success("El interesado ha sido notificado !");
        }, function (message) {
            alertify.success("Imposible notificar al interesado !");
            console.log(message);
        }
        );
    }
}

function consultaPeticiones(accion, objPeticion) {
    $.ajax({
        type: "POST",
        url: "templates/crudPeticiones.php?accion=" + accion,
        data: {
            idPeticion: objPeticion.idPeticion,
            name: objPeticion.nombre,
            email: objPeticion.email,
            number: objPeticion.telefono,
            issue: objPeticion.asunto
        },
        error: function (data) {
            console.error("Error peticion ajax para enviar información, DETALLES: " + data);
        },
        success: function (data) {
            if (accion == "leer") {
                $("#petitionsList").empty();
                $("#petitionsList").append(data);
                tabularPeticiones();
            }
            if (accion == "guardada") {
                consultaPeticiones("leer", { idPeticion: "", nombre: "", email: "", telefono: "", asunto: "" });
                alertify.alert('Petición guardada', 'En breve le haremos saber su fecha de cita mediante los datos proporcionados.');
                $("#petitionsList").empty();
                $("#petitionsList").append(data);
            }
            if (accion == "eliminada") {
                alertify.success("Petición eliminada exitosamente");
                consultaPeticiones("leer", { idPeticion: "", nombre: "", email: "", telefono: "", asunto: "" });
                // ENVIO DEL CORREO
                Email.send({
                    //SecureToken :"",
                    Host: "smtp.gmail.com",
                    Username: "secretariaTecXD@gmail.com",
                    Password: "1q2w3e4r5t?",
                    To: objPeticion.email,
                    From: "secretariaTecXD@gmail.com",
                    Subject: "Su cita ha sido cancelada.",
                    Body: "<b>Por este medio le informamos que su cita ha sido cancelada.</b>"
                }).then(function (message) {
                    alertify.success("El interesado ha sido notificado");
                }, function (message) {
                    alertify.success("Imposible notificar al interesado !");
                    console.log(message);
                }
                );
                $("#petitionsList").empty();
                $("#petitionsList").append(data);
            }
        }
    });
}

function tabularPeticiones() {
    $('#tablaPeticiones').DataTable({
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
                "<div><span class='pl-5 pr-4'></span>Existen _TOTAL_ peticiones</div>",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ peticiones)",
            sInfoPostFix: "",
            sSearch: "",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            aria: {
                SortAscending: ": Activar para ordenar la columna de manera ascendente",
                SortDescending:
                    ": Activar para ordenar la columna de manera descendente"
            }
        },
        scrollY: '65vh',
        scrollCollapse: true,
        "paging": false,
        "ordering": false
    });
}