base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista

function subirEmpresa(button) {
    var formData = new FormData($("form#form_empresa")[0]);
    $.ajax({
        method: "POST",
        url: $("form#form_empresa").attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            button.children('i').hide();
            button.attr('disabled', false);
            $('div#formulario_empresa').modal('hide');
            refreshTable(window.location.href);
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

function eliminarEmpresa(id,activar) {
    url = base_url.concat('/empresas/baja');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "id":id,
            "status":activar
        },
        success: function() {
            refreshTable(window.location.href);
            swal.close();
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema eliminando este producto, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function eliminarMultiplesEmpresas(checking, activar) {
    console.info(checking);
    url = base_url.concat('/empresas/baja/multiple');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "checking":checking,
            "status":activar
        },
        success: function(data) {
            refreshTable(window.location.href);
            swal.close();
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema eliminando los productos seleccionados, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function cargarExcelEmpresas(button) {
    var formData = new FormData($("div#importar-excel form")[0]);
    $.ajax({
        method: "POST",
        url: $("div#importar-excel form").attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            $('div#importar-excel').modal('hide');
            swal.close();
            button.children('i').hide();
            button.attr('disabled', false);
            refreshTable(window.location.href);
        },
        error: function(xhr, status, error) {
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema tratando de cargar el excel, por favor, trate nuevamente y asegúrese de que los datos del documento sean correctos.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function refreshTable(url) {
    var table = $("table#example3").dataTable();
    table.fnDestroy();
    $('div#div_tabla_empresas').fadeOut();
    $('div#div_tabla_empresas').empty();
    $('div#div_tabla_empresas').load(url, function() {
        $('div#div_tabla_empresas').fadeIn();
        $("table#example3").dataTable();
    });
    //setTimeout( function(){ mostrarOcultarBotones($('#exportar_empresas_excel, #eliminar_multiples_empresas'), 'example3') }, 1000);
}

function mostrarOcultarBotones(buttons, table_id) {
    var table = $('#'+table_id).DataTable();
    if (table.fnSettings().aoData.length > 0) {
        buttons.removeClass('hide');
    } else {
        buttons.addClass('hide');
    }
}
