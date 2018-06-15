/*Código para validar el formulario de datos del usuario*/
mb = 0;
extensionesPermitidas = ['jpg', 'jpeg', 'png', 'pdf'];//Mix
var inputs = [];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
var regExprNombre = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_\s .]{2,50}$/i;
var regExprEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{0,4})+$/;
var regExprNumReq = /^[0-9]{1,18}$/;
var regExprNum = /^[0-9]{0,18}$/;
var regExprCel = /^[ () \- + \d \s]{0,24}$/;
var btn = $("button#guardar_empleado");
btn.on('click', function() {
    inputs = [];
    msgError = '';

    !validarInput($('input#nombre'), regExprNombre) ? inputs.push('\n Nombre') : ''
    !validarInput($('input#apellido_paterno'), regExprNombre) ? inputs.push('\n Apellido patrerno') : ''
    !validarInput($('input#apellido_materno'), regExprNombre) ? inputs.push('\n Apellido materno') : ''
    !validarInput($('input#num_empleado'), regExprNumReq) ? inputs.push('\n Número de empleado') : ''
    !validarInput($('input#num_cuenta'), regExprNum) ? inputs.push('\n Número de cuenta') : ''
    //!validarInput($('input#ciudad'), regExprTexto) ? inputs.push('\n Ciudad') : ''
    !validarInput($('input#telefono'), regExprCel) ? inputs.push('\n Teléfono') : ''
    //!validarInput($('input#rfc'), regExprTexto) ? inputs.push('\n RFC') : ''
    //!validarInput($('input#curp'), regExprTexto) ? inputs.push('\n CURP') : ''
    !validarInput($('input#nss'), regExprNum) ? inputs.push('\n nss') : ''
    !validarInput($('input#telefono_emergencia'), regExprCel) ? inputs.push('\n Teléfono de emergencia') : ''

    if (inputs.length == 0) {
        console.log(inputs)
        /*btn.children('i').show();
        btn.attr('disabled', true);*/
        btn.hide();
        btn.submit();
    }
    else {
        console.log(inputs)
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "input#nombre" ).blur(function() {
    validarInput($(this), regExprNombre);
});
$( "input#apellido_paterno" ).blur(function() {
    validarInput($(this), regExprNombre);
});
$( "input#apellido_materno" ).blur(function() {
    validarInput($(this), regExprNombre);
});
$( "input#num_empleado" ).blur(function() {
    validarInput($(this), regExprNumReq);
});
$( "input#num_cuenta" ).blur(function() {
    validarInput($(this), regExprNum);
});
$( "input#telefono" ).blur(function() {
    validarInput($(this), regExprCel);
});
$( "input#nss" ).blur(function() {
    validarInput($(this), regExprNum);
});
$( "input#telefono_emergencia" ).blur(function() {
    validarInput($(this), regExprCel);
});

function validarInput (campo,regExpr) {
    if ($('form#form_repartidores input#id').val() != '' && $(campo).attr('name') == 'password' && $(campo).val() == '') {
        return true;
    } else if (!$(campo).val().match(regExpr)) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '\n';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}
/*Fin de código para validar el formulario de datos del usuario*/
