base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista
function guardarAsistencias(json,button) {
    url = base_url.concat('/guardarNominas');
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            'collection': json
        },
        success: function(response) {
            button.children('i.fa-spin').hide();
            button.children('i.fa-floppy-o').show();
            button.attr('disabled', false);
            console.log(response);
            if (response.status == 2) {
                //$('button#agregar_empleado').addClass('hide');
                $('a#btn-pagar').removeClass('hide');
            } /*else if (response.status != 0){
                $('div.contenedor-detalles button#pagar').removeClass('hide');
            }*/
            if( response.save ){
                swal('Éxito', 'Los cambios se han realizado correctamente', 'success')
            }
        },
        error: function(xhr, status, error) {
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema tratando de guardar las asistencias, por favor, trate nuevamente o recargue la página.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function cargarServicios(empresa_id, select) {
    url = base_url.concat('/pagos/servicios_empresa');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "empresa_id":empresa_id
        },
        success: function(data) {
            unblockUI(select);
            $('select#servicio_id').children('option').remove();
            $('select#servicio_id').append("<option value='0'>Seleccionar servicio</option>");
            $('select#servicio_id').select2("val", 0);
            data.forEach(function(row) {
                $('select#servicio_id').append("<option value="+ row.id +">"+ row.servicio +"</option>");
                console.log(row.horario);
            });
        },
        error: function(xhr, status, error) {
            unblockUI(select);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema eliminando este cupón, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function agregarEmpleado(button) {
    var formData = new FormData($("form#form-agregar-empleado")[0]);
    $.ajax({
        method: "POST",
        url: $("form#form-agregar-empleado").attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            button.children('i').hide();
            button.attr('disabled', false);
            $('div#modal-agregar-empleado').modal('hide');
            refreshTable(window.location.href+'/1');

        },
        error: function(xhr, status, error) {
            $('div#modal-agregar-empleado').modal('hide');
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema guardando cambios, porfavor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });

    $( document ).ajaxComplete(function() {
        $('table#nomina tbody').find('td.cell').each (function() {
            var col = $(this).prevAll().length;
            if (  !$(this).parents('table').find('th').eq(col).hasClass('edit') ){
                $(this).addClass('disabled')
            }
        });
    });
}

function eliminarEmpleadosLista(checking){
    url = base_url.concat('/pagos/eliminar_empleados');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "checking":checking
        },
        success: function(data) {
            swal.close();
            refreshTable(window.location.href+'/1');
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema dando de baja los empleados seleccionados, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
    $( document ).ajaxComplete(function() {
        $('table#nomina tbody').find('td.cell').each (function() {
            var col = $(this).prevAll().length;
            if (  !$(this).parents('table').find('th').eq(col).hasClass('edit') ){
                $(this).addClass('disabled')
            }
        });
    });
}

function refreshTable(url) {
    $('div#div_tabla_asistencias').fadeOut();
    $('div#div_tabla_asistencias').empty();
    $('div#div_tabla_asistencias').load(url, function() {
        $('div#div_tabla_asistencias').fadeIn();
    });
}
