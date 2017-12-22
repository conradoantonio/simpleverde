/*Código para validar el formulario de datos del usuario*/
var inputs = [];
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
//var regExprNum = /^[\d .]{1,}$/i;
var regExprNum = /^[ # \d \s]{0,10}$/i;
var regExprTel = /^[ \- + ( ) \d \s]{3,18}$/i;
var regExprNumReq = /^[ # \d \s]{1,10}$/i;
var regExprNumCasaReq = /^[ # a-z A-Z \d \s]{1,10}$/i;
var regExprNumCasa = /^[ # a-z A-Z \d \s]{0,10}$/i;
var btn_enviar = $("#guardar_empresa");
btn_enviar.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#nombre'), regExprTexto) ? '' : inputs.push('Nombre')
    validarInput($('input#oficina_cargo'), regExprTexto) ? '' : inputs.push('Oficina a cargo')
    validarInput($('textarea#direccion'), regExprTexto) ? '' : inputs.push('Dirección')
    validarInput($('input#contacto'), regExprTexto) ? '' : inputs.push('Contacto')
    validarInput($('input#telefono'), regExprTel) ? '' : inputs.push('Teléfono')
    validarInput($('input#marcacion_corta'), regExprTel) ? '' : inputs.push('Marcación corta')

    if (inputs.length == 0) {
        $(this).children('i').show();
        $(this).attr('disabled', true);
        subirEmpresa($(this));
    } else {
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "input#nombre" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#oficina_cargo" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "textarea#direccion" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#contacto" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#telefono" ).blur(function() {
    validarInput($(this), regExprTel);
});
$( "input#marcacion_corta" ).blur(function() {
    validarInput($(this), regExprTel);
});

function validarInput (campo,regExpr) {
    /*if (!$(campo).is(":visible")) {
        return true;
    } else */
    if (!$(campo).val().match(regExpr)) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '\n';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}

function validarSelect (select) {
    if ($(select).val() == '0' || $(select).val() == '' || $(select).val() == null) {
        $(select).parent().addClass("has-error");
        msgError = msgError + $(select).parent().children('label').text() + '\n';
        return false;
    } else {
        $(select).parent().removeClass("has-error");
        return true;
    }
}

$('#form_empresa input#logo').bind('change', function() {
    if ($(this).val() != '') {

        kilobyte = (this.files[0].size / 1024);
        mb = kilobyte / 1024;

        archivo = $(this).val();
        extension = archivo.split('.').pop().toLowerCase();

        if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
            swal({
                title: "Archivo no válido",
                text: "Debe seleccionar una imágen con formato jpg, jpeg o png, y debe pesar menos de 5MB",
                type: "error",
                closeOnConfirm: false
            });
        }
    }
});

function validarArchivo(campo) {
    archivo = $(campo).val();
    extension = archivo.split('.').pop().toLowerCase();

    if($('form#form_empresa input#id').val() != '' && ($(campo).val() == '' || $(campo).val() == null)) {
        return true;
    } else if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '\n';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}

/*Fin de código para validar el formulario de datos del usuario*/

/*Código para validar el archivo que importa datos desde excel*/
var btn_enviar_excel = $("#enviar-excel");
btn_enviar_excel.on('click', function() {
    fileExtension = ['xls', 'xlsx'];
    archivo = $("#archivo-excel").val();
    extension = archivo.split('.').pop().toLowerCase();

    if ($.inArray(extension, fileExtension) == -1) {
        swal({
            title: "Error",
            text: "<span>Solo son admitidos archivos con extensión <strong>xls y xlsx</strong><br>Extensión de archivo seleccionado: <strong>"+ extension +" </strong></span>",
            type: "error",
            html: true,
            confirmButtonColor: "#286090",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false,
        });
        return false;
    } else {
        $(this).children('i').show();
        $(this).attr('disabled', true);
        cargarExcelPlatillos(btn_enviar_excel);
    }
});
/*Fin del código para validar el archivo que importa datos desde excel*/