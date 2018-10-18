/*Código para validar el formulario de datos del usuario*/
$(function(){
    var mb = 0;
    var max_size = 3;
    var imgExtension = ['jpg','jpeg','png','gif','svg'];
    var pdfExtension = ['pdf'];
    var excelExtension = ['xls','xlsx'];
    var wordExtension = ['docx'];
    var inputs = [];
    var msgError = '';
    var re_rfc = /^([A-Z a-z,Ñ ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z a-z|\d]{3})$/;
    var re_email = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    var re_num_dec = /^[0-9]+([.][0-9]{1,2})?$/
    var regExprNombre = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_\s .]{2,50}$/i;
    var regExprPass = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_ .]{5,20}$/i;
    var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
    var regExprNum = /^\d+(\.\d{1,2})?$/i;
    var form = '';
    var btn_form = $(".save");

    $(".not-empty").on('blur change' , function() {
        if ( $(this).val() && $(this).val() != 0 ) {
            if ($(this).hasClass('select2')) {//Si es un select2 se remueve un error especial
                //$(this).parent().children('div.select2').children('ul.select2-choices').removeClass("select-error");
                $(this).parent().children('div.select2-container').removeClass("select-error");
            } else if($(this).hasClass('selectpicker')) {
                $(this).parent().children('button.dropdown-toggle').removeClass("select-error");
            } else {
                $(this).parent().removeClass('has-error');
            }
        } else {
            if ($(this).hasClass('select2')) {//Si es un select2 se agrega un error especial
                $(this).parent().children('div.select2').children('ul.select2-choices').addClass("select-error");
                $(this).parent().children('div.select2-container').addClass("select-error");

            } else if ($(this).hasClass('selectpicker')) {//Si es un selectpicker se agrega un error especial
                $(this).parent().children('button.dropdown-toggle').addClass("select-error");
            } else {
                $(this).parent().addClass('has-error');
            }
        }
    });

    $(".email").blur(function() {
        if(!$(this).val().match(re_email)) {
            if ( !$(this).parent().hasClass("has-error") ){
                $(this).parent().addClass('has-error')
            }
        } else {
            $(this).parent().removeClass('has-error')
        }
    });

    $(".rfc").blur(function() {
        if(!$(this).val().match(re_rfc)) {
            if ( !$(this).parent().hasClass("has-error") ){
                $(this).parent().addClass('has-error')
            }
        } else {
            $(this).parent().removeClass('has-error')
        }
    });

    $(".decimal").blur(function() {
        if(!$(this).val().match(re_num_dec)) {
            if ( !$(this).parent().hasClass("has-error") ){
                $(this).parent().addClass('has-error')
            }
        } else {
            $(this).parent().removeClass('has-error')
        }
    });

    btn_form.on('click', function() {
        inputs = [];
        msgError = '';
        form = $(this).closest('form');

        form.find('input, select, textarea').each(function(i,e) {
            if ( $(this).hasClass('not-empty') ) {//Required fields
                if ( !$(this).val() || $(this).val() == 0 ) {//If empty or nothing selected
                    if ($(this).hasClass('select2')) {
                        $(this).parent().children('div.select2').children('ul.select2-choices').addClass("select-error");
                        $(this).parent().children('div.select2-container').addClass("select-error");
                    } else if ($(this).hasClass('selectpicker')) {//Si es un selectpicker se agrega un error especial
                        $(this).parent().children('button.dropdown-toggle').addClass("select-error");
                    } else {
                        $(this).parent().addClass('has-error');
                    }
                    inputs.push($(this).data('msg'));
                    msgError = msgError +"<li>"+$(this).data('msg')+": Campo vacio</li>";
                } else {
                    if ($(this).hasClass('select2')) {
                        $(this).parent().children('div.select2-container').removeClass("select-error");
                        //$(this).parent().children('button.dropdown-toggle').removeClass("select-error");
                        //$(this).parent().children('div.select2').children('ul.select2-choices').removeClass("select-error");
                    } else if ($(this).hasClass('selectpicker')) {
                        $(this).parent().children('button.dropdown-toggle').removeClass("select-error");
                    } else {
                        $(this).parent().removeClass('has-error');
                    }
                }
            }

            if ( $(this).hasClass('email') ) {
                if(!$(this).val().match(re_email)) {
                    if ( !$(this).parent().hasClass("has-error") ) {//If has content but it is not the correct
                        $(this).parent().addClass('has-error');
                        inputs.push($(this).data('msg'));
                        msgError = msgError +"<li>"+$(this).data('msg')+": Correo inválido</li>";
                    }
                }
            }

            if ( $(this).hasClass('rfc') ) {
                if(!$(this).val().match(re_rfc)) {
                    if ( !$(this).parent().hasClass("has-error") ) {//If has content but it is not the correct
                        $(this).parent().addClass('has-error')
                        inputs.push($(this).data('msg'));
                        msgError = msgError +"<li>"+$(this).data('msg')+": RFC inválido</li>";
                    }
                }
            }

            if ( $(this).hasClass('decimal') ) {
                if (!$(this).val().match(re_num_dec)) {
                    if ( !$(this).parent().hasClass("has-error") ){
                        $(this).parent().addClass('has-error');
                        inputs.push($(this).data('msg'));
                        msgError = msgError +"<li>"+$(this).data('msg')+": Valor inválido</li>";
                    }
                }
            }

            if ( $(this).hasClass('file') ) {
                file = $(this).val();
                extension = file.split('.').pop().toLowerCase();
                var arr_extensions = [];

                if ( $(this).hasClass('image') ) {
                    arr_extensions = $.merge(arr_extensions, imgExtension);
                }

                if ( $(this).hasClass('excel') ) {
                    arr_extensions = $.merge(arr_extensions, excelExtension);
                }

                if ( $(this).hasClass('word') ) {
                    arr_extensions = $.merge(arr_extensions, wordtension);
                }

                if ( $(this).hasClass('pdf') ) {
                    arr_extensions = $.merge(arr_extensions, pdfExtension);
                }

                if ( $(this).val() ) {
                    if ( !$(this).parent().hasClass("has-error") ) {
                        kilobyte = ( $(this)[0].files[0].size / 1024 );
                        mb = kilobyte / 1024;

                        if ($.inArray(extension, arr_extensions) == -1 || mb > max_size) {
                            if ( !$(this).parent().hasClass("has-error") ){
                                if ( $.inArray(extension, arr_extensions) == -1 ) {
                                    type_error = "Extensiones permitidas: "+arr_extensions;
                                } else {
                                    type_error = "El arhivo debe ser menor a "+max_size+" mb";
                                }
                                $(this).parent().addClass("has-error");
                                msgError = msgError +"<li>"+$(this).data('msg')+": "+type_error+"</li>";
                                inputs.push($(this).data('msg'));
                            }
                        } else {
                            $(this).parent().removeClass("has-error");
                        }
                    }
                }
            }
        });

        if (inputs.length == 0) {
            swal({
                title: "Guardando.",
                text: "<div><i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i></div>",
                html:true,
                showConfirmButton: false,
            });
       /*     swal({
                title: 'Guardando',
                buttons: false,
                closeOnEsc: false,
                closeOnClickOutside: false,
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i>"
                    },
                }
            }).catch(swal.noop);*/

            ajaxType = form.data('ajax-type');
            config = {
                'redirect'      : form.data('redirect'),
                'refresh'       : form.data('refresh'),
                'column'        : form.data('column'),
                'table_id'      : form.data('table_id'),
                'container_id'  : form.data('container_id'),
            }
            if (ajaxType == 'ajax-form') { ajaxForm(form.attr('id'), config); }
            else if (ajaxType == 'ajax-form-modal') { ajaxFormModal(form.attr('id'), config); }
        } else {
            swal({
                title: "Verifique los siguientes campos:",
                text: "<ul class='error_list'>"+msgError+"</ul>",
                type: "error",
                /*allowEscapeKey: false,*/
                html:true,
            });
            /*swal({
                title: 'Verifique los siguientes campos: ',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'>"+msgError+"</ul>"
                    },
                }
            }).catch(swal.noop);*/
            $(".guardar").prop( "disabled", false ).removeClass('disabled');
            return false;
        }
    });
});
/*Fin de código para validar el formulario de datos del usuario*/