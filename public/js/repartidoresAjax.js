base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista

function guardarRepartidor(button) {
    var formData = new FormData($("form#form_repartidores")[0]);
    $.ajax({
        method: "POST",
        url: $("form#form_repartidores").attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            button.children('i').hide();
            button.attr('disabled', false);
            $('div#editar-repartidor').modal('hide');
            if (data.msg == 'Email unavailable') {
                $('div#request-error').removeClass('hide');
            } else {
                $('div#request-error').addClass('hide');
                refreshTable(window.location.href);
            }
        },
        error: function(xhr, status, error) {
            $('div#editar-repartidor').modal('hide');
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema guardando los datos del repartidor, porfavor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function eliminarBloquearUsuario(id,status,correo,token) {
    url = base_url.concat('/usuario/cambiarStatus');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "id":id,
            "status":status,
            "correo":correo,
            "_token":token
        },
        success: function() {
            status_usuario = (status == '0' ? 'borrado' :  (status == '1' ? 'reactivado' : (status == '2' ? 'bloqueado' : '')))

            swal({
                title: "Usuario " + status_usuario + " correctamente.",
                type: "success",
                timer: 2000,
            });
            refreshTable(window.location.href);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>Error!</small>",
                text: "Se encontró un problema cambiando el status del usuario, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function refreshTable(url) {
    var table = $("table#example3").dataTable();
    table.fnDestroy();
    $('div#tabla_repartidores').fadeOut();
    $('div#tabla_repartidores').empty();
    $('div#tabla_repartidores').load(url, function() {
        $('div#tabla_repartidores').fadeIn();
        $("table#example3").dataTable();
    });
}
