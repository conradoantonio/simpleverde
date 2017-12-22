base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista
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
