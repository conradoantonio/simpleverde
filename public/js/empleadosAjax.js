base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista

function bajaEmpleado(id, activar) {
    url = base_url.concat('/empleados/baja');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "id":id,
            "status":activar
        },
        success: function() {
            swal.close();
            refreshTable(window.location.href);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>Error!</small>",
                text: "Se encontró un problema cambiando el status de este empleado, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function darBajaMultiplesEmpleados(checking, activar) {
    console.info(checking);
    url = base_url.concat('/empleados/baja/multiple');
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
                text: "Se encontró un problema cambiando el status de los empleados seleccionados, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function refreshTable(url) {
    var table = $("table#example3").dataTable();
    table.fnDestroy();
    $('div#div_tabla_empleados').fadeOut();
    $('div#div_tabla_empleados').empty();
    $('div#div_tabla_empleados').load(url, function() {
        $('div#div_tabla_empleados').fadeIn();
        $("table#example3").dataTable();
    });
}
