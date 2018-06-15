base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista
console.info(base_url);
function eliminarListas(checking) {
    url = base_url.concat('/nominas/eliminar_listas');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "checking":checking
        },
        success: function() {
            swal.close();
            refreshTable(window.location.href);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>Error!</small>",
                text: "Se encontró un problema eliminando la pregunta, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function refreshTable(url) {
    var table = $("table#example3").dataTable();
    table.fnDestroy();
    $('div#div_tabla_listas').fadeOut();
    $('div#div_tabla_listas').empty();
    $('div#div_tabla_listas').load(url, function() {
        $('div#div_tabla_listas').fadeIn();
        $("table#example3").dataTable();
    });
}