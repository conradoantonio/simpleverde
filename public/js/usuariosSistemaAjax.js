base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista

function guardarUsuario(button) {
    var formData = new FormData($("form#form_usuario_sistema")[0]);
    $.ajax({
        method: "POST",
        url: $("form#form_usuario_sistema").attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            button.children('i').hide();
            button.attr('disabled', false);
            $('div#formulario-usuario-sistema').modal('hide');
            if (data.msg == 'Email unavailable') {
                $('div#request-error').removeClass('hide');
            } else {
                $('div#request-error').addClass('hide');
                refreshTable(window.location.href);
            }
        },
        error: function(xhr, status, error) {
            $('div#formulario-usuario-sistema').modal('hide');
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema guardando este usuario, porfavor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function eliminarUsuarioSistema(id,token) {
    url = base_url.concat('/usuarios/sistema/eliminar_usuario');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "id":id,
            "_token":token
        },
        success: function() {
            swal({
                title: "Usuario eliminado correctamente.",
                type: "success",
                timer: 2000,
            });
            refreshTable(window.location.href);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>Error!</small>",
                text: "Se encontró un problema eliminando este usuario, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function refreshTable(url) {
    var table = $("table#example3").dataTable();
    table.fnDestroy();
    $('div#tabla_usuarios_sistema').fadeOut();
    $('div#tabla_usuarios_sistema').empty();
    $('div#tabla_usuarios_sistema').load(url, function() {
        $('div#tabla_usuarios_sistema').fadeIn();
        $("table#example3").dataTable();
    });
}
