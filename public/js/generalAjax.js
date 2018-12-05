//Autor: Luis Castañeda
//Plagiado por: Conrado Carrillo
function ajaxForm(form_id, config) {
    var formData = new FormData($("form#"+form_id)[0]);
    var button = $("form#"+form_id).find('button.save');
    $.ajax({
        method: "POST",
        url: $("form#"+form_id).attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            swal({
                title: data.status == 'success' ? 'Bien: ' : 'Error',
                text: "<p class='text-response'>"+data.msg ? data.msg : "¡Cambios guardados exitosamente!"+"</p>",
                type: data.status ? data.status : "success",
                html:true,
                showConfirmButton: false,
                allowEscapeKey: false,
            });

            if (config.refresh == 'table') {
                    refreshTable(data.url, config.column, config.table_id, config.container_id);
            } else if (config.refresh == 'galery') {
                    refreshGalery(data.url, config.container_id);
            } else if (config.refresh == 'content') {
                    refreshContent(data.html, config.container_id);
            } else if (config.redirect) {
                setTimeout( function() {
                    if (data.url) {
                        window.location.href = data.url;
                    }
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}

function ajaxFormModal(form_id, config) {
    var formData = new FormData($("form#"+form_id)[0]);
    $.ajax({
        method: "POST",
        url: $("form#"+form_id).attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            $('div.modal').modal('hide');
            //swal.close();
            swal({
                title: data.status == 'success' ? 'Bien: ' : 'Error',
                text: "<p class='text-response'>"+data.msg ? data.msg : "¡Cambios guardados exitosamente!"+"</p>",
                type: data.status ? data.status : "success",
                html:true,
                showConfirmButton: false,
                allowEscapeKey: false,
                timer: 2000,
            });

            if (config.refresh) {
                refreshTable(data.url, config.column, config.table_id, config.container_id);
            } else if(config.redirect) {
                setTimeout( function() {
                    window.location.href = data.url;
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}


function ajaxSimple(config) {
    $.ajax({
        method: config.method ? config.method : "POST",
        url: config.route,
        data: config,
        success: function(data) {
            if (!config.keepModal) { $('div.modal').modal('hide'); }
            
            if(!config.callback) {
                swal({
                    title: data.status == 'success' ? 'Bien: ' : 'Error',
                    text: "<p class='text-response'>"+data.msg ? data.msg : "¡Cambios guardados exitosamente!"+"</p>",
                    type: data.status ? data.status : "success",
                    html:true,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    timer: 2000,
                });
            } else {
                swal.close();
            }

            if (config.refresh == 'table') {
                refreshTable(data.url, config.column, config.table_id, config.container_id);
            } else if (config.refresh == 'galery') {
                refreshGalery(data.url, config.container_id);
            } else if (config.refresh == 'content') {
                    refreshContent(data.html, config.container_id);
            } else if(config.callback) {
                window[config.callback](data, config);
            } else if(config.redirect) {
                setTimeout( function() {
                    window.location.href = data.url;
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}

/*function ajaxSimple(config) {
    $.ajax({
        method: config.method ? config.method : "POST",
        url: config.route,
        data: config,
        success: function(data) {
            $('div.modal').modal('hide');
            swal.close();
            if (config.refresh == 'table') {
                    refreshTable(data.url, config.column, config.table_id, config.container_id);
            } else if (config.refresh == 'galery') {
                    refreshGalery(data.url, config.container_id);
            } else if(config.redirect) {
                setTimeout( function() {
                    window.location.href = data.url;
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}*/

function ajaxMSimple(data) {
    url = baseUrl.concat(data.url);
    $.ajax({
        method: "POST",
        url: url,
        data: data,
        success: function(response) {
            $( ".fill-container" ).addClass('hide');
            fill_text(response,data.modal_id);
            
            if (response.cancelacion) {
                fill_text(response.cancelacion, null);
            }
            
            $("table#detalles tbody").children().remove();

            /*Detalles de pedido (Productos)*/
            items = response.detalles;
            for (var key in items) {
                if (items.hasOwnProperty(key)) {
                    $("table#detalles tbody").append(
                        '<tr>'+
                            '<td class="text-center">'+items[key].nombre+'</td>'+
                            '<td class="text-center">$'+(items[key].precio / 100)+'</td>'+
                            '<td class="text-center">'+(items[key].cantidad)+'</td>'+
                            '<td class="text-center">$'+((items[key].precio * items[key].cantidad) / 100)+'</td>'+
                        '</tr>'
                    );
                }
            }

            $("table#detalles tbody").append(
                '<tr>'+
                    '<td class="text-center"></td>'+
                    '<td class="text-center"></td>'+
                    '<td class="text-center bold">Costo total</td>'+
                    '<td class="text-center">$'+(response.costo_total/100)+'</td>'+
                '</tr>'
            );
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema con el servidor, por favor, trate nuevamente.<br><span>" + JSON.parse(xhr.responseText).msg + "</span><br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                type: 'error',
                html: true
            });
        }
    });
}

function fill_text(response, modal_id) {
    //$( ".fill-container" ).addClass('hide');
    var keyNames = Object.keys(response);

    for (var i in keyNames) {
        prop_name = keyNames[i];
        if (response[prop_name]) {
            $( ".data-fill" ).find( "."+prop_name ).text(response[prop_name]);
            $( ".data-fill" ).find( "."+prop_name ).closest('.fill-container').removeClass('hide');
        }
    }
    if (modal_id) {
        $('div#'+modal_id).modal();
    }
}

function displayAjaxError(xhr, status, error) {
    $('div.modal').modal('hide');
    //swal.close();
    if (/^[\],:{}\s]*$/.test(xhr.responseText.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
        display = JSON.parse(xhr.responseText).msg;
        class_type = JSON.parse(xhr.responseText).status;
    } else {
        display = '';
        class_type = 'error';
    }

    if (class_type == 'error') { title = '¡Error!'; txt_msg = 'Ha ocurrido un error'; }
    if (class_type == 'info') { title = 'Información'; txt_msg = 'Detalles:'; }
    if (class_type == 'warning') { title = '¡Atención!'; txt_msg = 'Información importante:'; }

    swal({
        title: "<small>"+title+"</small>",
        text: ""+txt_msg+"<br><span>" + display + "</span><br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
        type: class_type,
        html: true
    });
}
