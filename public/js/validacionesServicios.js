/*Código para validar el formulario de datos del usuario*/
var inputs = [];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
//var regExprNum = /^[\d .]{1,}$/i;
var regExprNum = /^[\d \s]{1,10}$/i;
var regExprNumDec = /^\d+(?:\.\d{0,2})$/i;
var regExprNumNotReq = /^[\d \s]{0,10}$/i;
var btn_enviar = $("#guardar_servicio");
btn_enviar.on('click', function() {
    inputs = [];
    msgError = '';
    
    validarInput($('input#servicio_id'), regExprNumNotReq) ? '' : inputs.push('Servicio ID')
    validarInput($('input#empresa_id'), regExprNum) ? '' : inputs.push('Empresa ID')
    validarInput($('input#servicio'), regExprTexto) ? '' : inputs.push('Servicio')
    validarInput($('input#horario'), regExprTexto) ? '' : inputs.push('Horario')
    validarInput($('input#sueldo'), regExprNum) ? '' : inputs.push('Sueldo')
    validarInput($('input#sueldo_diario_guardia'), regExprNumDec) ? '' : inputs.push('Sueldo diario por guardia')

    if (inputs.length == 0) {
        $(this).children('i').show();
        $(this).attr('disabled', true);
        guardarServicio($(this));
    } else {
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "input#servicio_id" ).blur(function() {
    validarInput($(this), regExprNumNotReq);
});
$( "input#empresa_id" ).blur(function() {
    validarInput($(this), regExprNum);
});
$( "input#servicio" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#horario" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#sueldo" ).blur(function() {
    validarInput($(this), regExprNum);
});
$( "input#sueldo_diario_guardia" ).blur(function() {
    validarInput($(this), regExprNumDec);
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