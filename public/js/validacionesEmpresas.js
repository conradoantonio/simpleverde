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

/*Fin de código para validar el formulario de datos del usuario*/
