/*Código para validar el formulario de datos del usuario*/
var inputs = [];
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var msgError = '';
var regExprTextoLimite = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ % ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,50}$/i;
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ % ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
var regExprDate = /^\d{4}-\d{2}-\d{2}$/i;
var regExprNum = /^[\d .]{1,}$/i;
var btn_enviar = $("button#guardar_pago");
btn_enviar.on('click', function() {
    inputs = [];
    msgError = '';
    
    validarSelect($('select#empresa_id')) == false ? inputs.push('Empresa') : ''
    validarSelect($('select#servicio_id')) == false ? inputs.push('Servicio') : ''
    validarInputDate($('input#fecha_inicio'), regExprDate) == false ? inputs.push('Fecha inicio') : ''
    validarInputDate($('input#fecha_fin'), regExprDate) == false ? inputs.push('Fecha fin') : ''
    validarInput($('input#num_empleados'), regExprNum) == false ? inputs.push('Número de empleados') : ''
    validarSelect($('select#trabajadores_id')) == false ? inputs.push('Trabajadores') : ''

    if (inputs.length == 0) {
        $(this).hide();
        $(this).submit();
    } else {
        $(this).show();
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "select#empresa_id" ).change(function() {
    validarSelect($(this));
});
$( "select#servicio_id" ).change(function() {
    validarSelect($(this));
});
$( "input#fecha_inicio" ).blur(function() {
    validarInputDate($(this), regExprDate);
});
$( "input#fecha_fin" ).blur(function() {
    validarInputDate($(this), regExprDate);
});
$( "input#num_empleados" ).blur(function() {
    validarInput($(this), regExprNum);
});
$( "select#trabajadores_id" ).change(function() {
    validarSelect($(this));
});

function validarInputDate (campo,regExpr) {
    if (!$(campo).val().match(regExpr)) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().parent().children('label').text() + '\n';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}

function validarInput (campo,regExpr) {
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
        $(select).parent().children('div.select2-container').addClass("select-error");
        msgError = msgError + $(select).parent().children('label').text() + '\n';
        return false;
    } else {
        $(select).parent().children('div.select2-container').removeClass("select-error");
        return true;
    }
}

