base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista

function cargarServicios(empresa_id, btn) {
    url = base_url.concat('/empresas/servicios');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "empresa_id":empresa_id
        },
        success: function(data) {
            btn.find('i.fa').hide();
            btn.attr('disabled', false);
            refreshTableServicios(data);
            $('#servicio_dialogo').modal();
            $('a[href="#tabNuevoServicio"]').text('Nuevo servicio');
        },
        error: function(xhr, status, error) {
            btn.find('i.fa').hide();
            btn.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema cargando los servicios de esta empresa, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}
function guardarServicio(button) {
    var formData = new FormData($("form#form_servicios")[0]);
    $.ajax({
        method: "POST",
        url: $("form#form_servicios").attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            button.children('i').hide();
            button.attr('disabled', false);
            var table = $("table#tabla_servicio").dataTable();
            table.fnDestroy();
            refreshTableServicios(data);
        },
        error: function(xhr, status, error) {
            $('div#formulario_empresa').modal('hide');
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema guardando este registro, porfavor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function eliminarServicio(servicio_id,empresa_id) {
    url = base_url.concat('/empresas/servicios/eliminar');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "servicio_id":servicio_id,
            "empresa_id":empresa_id
        },
        success: function(data) {
            swal.close();
            var table = $("table#tabla_servicio").dataTable();
            table.fnDestroy();
            refreshTableServicios(data);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema eliminando este registro, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function refreshTableServicios(data) {
    $('div#tabla-servicios').children().remove();
    $('div#tabla-servicios').append(data);

    $('div#tabla-servicios').fadeOut();
    //$('div#tabla-servicios').empty();
    
    $('div#tabla-servicios').fadeIn();
    $("table#tabla_servicio").dataTable({
        "aaSorting": [[ 0, "desc" ]]
    });
    
    $('a[href="#tabTablaServicio"]').tab('show');
}