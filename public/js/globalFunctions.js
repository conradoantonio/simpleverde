//Shows the loading swal
function loadingMessage(msg = false) {
    swal({
        title: msg ? msg : 'Espere un momento porfavor',
        showCancelButton: false,
        showConfirmButton: false,
        allowEscapeKey: false,
        allowOutsideClick: false,
        closeOnConfirm: false,
        html: true,
        text: "<div><i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i></div>"
    });
}

//Clear inputs, selects, textareas, etc
function clearFields(parent = false, button = false) {
    sel = parent ? parent : $('body');
    sel.find('div.form-group').removeClass('has-error');
    sel.find("input.form-control").val('');
    sel.find("select.form-control").val(0);

    button ? button.click() : '';
}

//Reload a table, then initializes it as datatable
function refreshTable(url, column, table_id, container_id) {
    $('.delete-rows').attr('disabled', true);
    var table = table_id ? $("table#"+table_id).dataTable() : $("table#example3").dataTable();
    var container = container_id ? $("div#"+container_id) : $('div#table-container');
    table.fnDestroy();
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
        $(table_id ? "table#"+table_id : "table#example3").dataTable({
            "aaSorting": [[ column ? column : 1, "desc" ]]
        });
    });
}

//Reload a table by htm
function refreshTableByHtml(html, column, table_id, container_id) {
    $('.delete-rows').attr('disabled', true);
    var table = table_id ? $("table#"+table_id).dataTable() : $("table#example3").dataTable();
    var container = container_id ? $("div#"+container_id) : $('div#table-container');
    table.fnDestroy();
    container.fadeOut();
    container.empty();
    container.append(html);
    container.fadeIn();
    $(table_id ? "table#"+table_id : "table#example3").dataTable({
        "aaSorting": [[ column ? column : 1, "desc" ]]
    });
}

//Reload a galery module
function refreshGalery(url, container_id) {
    var container = container_id ? $("div#"+container_id) : $('div#galery-container');
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
    });
}

//Reload likes and dislikes for an event
function refreshLikes(event, rates, user, rate_by_user) {
    var likes = dislikes = 0;

    for (var key in rates) {
        if (rates.hasOwnProperty(key)) {
            rates[key].like == 1 ? likes ++ : dislikes++;
        }
    }

    l_msg = rate_by_user == 1 ? ' le gusta el ' : ' no le gusta el ';
    l_msg = l_msg + ' ' + event.type + ' ' + event.name;

    $('.likes-counter').text(likes);
    $('.dislikes-counter').text(dislikes);
    
    toastr.info('A ' + ' ' +user.name + ' ' +user.lastname + l_msg);
}

//Init functions
$(function() {
    //Set up the ajax to include csrf token on header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Fade in the containers
    setTimeout(function() {
        $('div.row-fluid, div.form-container').fadeIn('low');
    }, 500);

    //Show tooltips
    $('[data-toggle="tooltip"]').tooltip()

    //Verify if the button for delete multiple can be clickable
    $('body').delegate('.checkDelete','click', function() {
        var ids_lenght = [];
        $("input.checkDelete").each(function() {
            if ($(this).is(':checked')) {
                ids_lenght.push($(this).parent().parent().siblings("td:nth-child(2)").text());
            }
        });

        $('.delete-rows').attr('disabled', ids_lenght.length > 0 ? false : true);
    });

    //Set up the select 2 inputs
    /*$("select.select2").select2();*/

    //Set up the clockpicker inputs
    /*$('.clockpicker ').clockpicker({
        autoclose: true
    });*/

    //Set up the datepiciker inputs
    $( ".date-picker" ).datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
    });

    //Set up the button to download the excel file
    $('body').delegate('button.export-excel','click', function() {
        window.location.href = $('div.general-info').data('url')+'/excel/export';
    });

    //Configure the modal and form properties to upload files
    $('body').delegate('button.upload-content','click', function() {
        var path = $(this).data('path');
        var action = $(this).data('route-action');
        var myDropzone = Dropzone.forElement(".myDropzone");

        if (typeof $(this).data('width') !== 'undefined') {
            $('#rule-container').find('p').removeClass('hide');
            $('#rule-container').children('p').find('strong').text($(this).data('width')+'x'+$(this).data('height')+ 'px');
        }

        myDropzone.options.url = action;

        $('form#dropzone-form').find('input#path').val(path);
        
        /*myDropzone.on("queuecomplete", function(file) {
            if (typeof $('button.upload-content').data('refresh') !== 'undefined') {
                refreshGalery(window.location.href)
            }
        });*/
    });

    //Configure the modal to clean the files and reload the galery if neccesary when this is closed by the user
    $('body').delegate('div#modal-upload-content','hidden.bs.modal', function() {
        var myDropzone = Dropzone.forElement(".myDropzone");
        
        //First check if files where uploaded, if so, refresh the galery
        if (typeof $('button.upload-content').data('refresh') !== 'undefined') {
            if (myDropzone.files.length > 0) {
                refreshGalery(window.location.href);
            }
        }

        //Clear dropzone files
        myDropzone.removeAllFiles();
        $(this).find('input.form-control').val('');
    });

    //Configure the modal and form properties to import with excel
    $('body').delegate('button.import-excel','click', function() {
        var action = $('div.general-info').data('url')+'/excel/import';
        var fields = $(this).data('fields');
        $('form#form-import').get(0).setAttribute('action', action);
        $('form#form-import').find('strong#fields').text(fields);
    });

    //Clear modal inputs
    $('div.modal').on('hidden.bs.modal', function (e) {
        $(this).find('div.form-group').removeClass('has-error');
        $(this).find("input.form-control, textarea.form-control").val('');
        $(this).find("select").val(0);
        $(this).find("select.select2").val(0).trigger('change');
        $(this).find('div.select2-container').removeClass("select-error");
    });

    //Send a request for a single delete
    $('body').delegate('.enable-row, .disable-row','click', function() {
        var route = $('div.general-info').data('url')+'/baja';
        var status = $('div.general-info').data('status');
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        var row_id = $(this).parent().siblings("td:nth-child(2)").text();
        var swal_msg = status == 1 ? 'baja' : 'alta';
        ids_array.push(row_id);

        swal({
            title: 'Se dará de ' + swal_msg + ' el registro con el ID ' + row_id + ', ¿Está seguro de continuar?',
            text: "¡Cuidado!",
            html: true,
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, continuar",
            allowEscapeKey: true,
            allowOutsideClick: true,
            closeOnConfirm: false
        },
        function() {
            config = {
                'route'   : route,
                'ids'     : ids_array,
                'status'  : status == 1 ? 0 : 1,
                'refresh' : refresh,
            }
            loadingMessage();
            ajaxSimple(config);
        });
    });

    //Send a request for a single delete
    $('body').delegate('.delete-row','click', function() {
        var route = $('div.general-info').data('url')+'/baja';
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        var row_id = $(this).parent().siblings("td:nth-child(2)").text();
        ids_array.push(row_id);

        swal({
            title: 'Se dará de baja el registro con el ID '+row_id+', ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                config = {
                    'route'     : route,
                    'ids'       : ids_array,
                    'refresh'   : refresh,
                }
                loadingMessage();
                ajaxSimple(config);
            }
        }).catch(swal.noop);
    });
        
    //Send a request for multiple delete
    $('body').delegate('.disable-rows, enable-rows','click', function() {
        var route = $('div.general-info').data('url')+'/baja';
        var status = $('div.general-info').data('status');
        var refresh = $('div.general-info').data('refresh');
        var swal_msg = status == 1 ? 'baja ' : 'alta ';
        var ids_array = [];
        $("input.checkDelete").each(function() {
            if($(this).is(':checked')) {
                ids_array.push($(this).parent().parent().parent().attr('id'));
            }
        });
        if (ids_array.length > 0) {
            swal({
                title: 'Se dará de ' + swal_msg + ids_array.length + ' registro(s), ¿Está seguro de continuar?',
                text: "¡Cuidado!",
                html: true,
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, continuar",
                allowEscapeKey: true,
                allowOutsideClick: true,
                closeOnConfirm: false
            },
            function() {
                config = {
                    'route'   : route,
                    'ids'     : ids_array,
                    'status'  : status == 1 ? 0 : 1,
                    'refresh' : refresh,
                }
                loadingMessage();
                ajaxSimple(config);
            });
        }
    });
});
