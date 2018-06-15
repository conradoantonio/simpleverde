@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style>
textarea {
    resize: none;
}
th {
    text-align: center!important;
}
/* Change the white to any color ;) */
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset !important;
}
.table td.text {
    max-width: 177px;
}
.table td.text span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    max-width: 100%;
}
</style>
<div class="text-center" style="margin: 20px;">

    @include('empresas.form_empresa')

    <h2>Lista de clientes (empresas)</h2>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_tipo_servicio" id="servicio_dialogo">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="titulo_tipo_servicio">Servicios</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="tab-01">
                                <li class="active"><a href="#tabTablaServicio">Tabla servicios</a></li>
                                <li><a href="#tabNuevoServicio">Nuevo servicio</a></li>
                            </ul>
                            <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabTablaServicio">
                                    <button type="button" class="btn btn-primary" id="nuevo_servicio"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo servicio</button>
                                    <h3>Tabla de servicios disponibles: </h3>
                                    <div class="table-responsive" id="tabla-servicios">
                                        {{-- @include('empresas.tabla_servicio') --}}
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabNuevoServicio">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form enctype="multipart/form-data" action="" method="POST" onsubmit="return false;" autocomplete="off" id="form_servicios">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xs-12 hide">
                                                        <div class="form-group">
                                                            <label for="id">ID</label>
                                                            <input type="text" class="form-control" id="servicio_id" name="servicio_id">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xs-12 hide">
                                                        <div class="form-group">
                                                            <label for="id">Empresa ID</label>
                                                            <input type="text" class="form-control" id="empresa_id" name="empresa_id">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="servicio">Servicio</label>
                                                            <input type="text" class="form-control" id="servicio" name="servicio" placeholder="Ej. 01 servicio de 24x24 hrs.">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="horario">Horario</label>
                                                            <input type="text" class="form-control" id="horario" name="horario" placeholder="Ej. Lunes a Viernes de 7:00 a 7:00">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sueldo">Sueldo</label>
                                                            <input type="text" class="form-control" id="sueldo" name="sueldo" maxlength="6" placeholder="Ej. 2600">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sueldo_diario_guardia">Sueldo diario por guardia</label>
                                                            <input type="text" class="form-control" id="sueldo_diario_guardia" name="sueldo_diario_guardia" maxlength="6" placeholder="Ej. 250.50">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary" id="guardar_servicio">
                                                    <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                                    Guardar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="row-fluid" style="display: none">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div class="general-info" data-url="{{url('empresas')}}" data-refresh="table" data-status="{{$status}}">
                        <a href="{{url("empresas/exportar/general/{$status}")}}">
                            <button type="button" class="btn btn-info {{count($empresas) ? '' : 'hide'}}" id="exportar_empresas_excel"><i class="fa fa-download" aria-hidden="true"></i> Exportar clientes</button>
                        </a>
                        <button type="button" class="btn btn-danger disable-rows enable-rows {{count($empresas) ? '' : 'hide'}}"><i class="fa {{$status == 1 ? 'fa-trash' : 'fa-undo'}}" aria-hidden="true"></i> {{$status == 1 ? 'Dar de baja' : 'Reactivar empresas'}}</button>
                        @if($status == 1)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formulario_empresa" id="nuevo_empresa"><i class="fa fa-plus" aria-hidden="true"></i> Nueva empresa</button>
                        @endif
                    </div>
                    <div class="grid-body">
                        <div class="table-responsive" id="div_tabla_empresas">
                            @include('empresas.tabla')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/tabs_accordian.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/empresasAjax.js') }}"></script>
<script src="{{ asset('js/serviciosAjax.js') }}"></script>
<script src="{{ asset('js/validacionesEmpresas.js') }}"></script>
<script src="{{ asset('js/validacionesServicios.js') }}"></script>
<script type="text/javascript">
/**
 *==================================================================================================================================================================================
 *=                                                           Empiezan las funciones relacionadas a la tabla de empresas                                                           =
 *==================================================================================================================================================================================
 */

$('body').delegate('button#nueva_empresa','click', function() {
    $('div#logo_empresa').hide();
    $("h4#titulo_form_empresa").text('Nueva empresa');
    $("form#form_empresa").get(0).setAttribute('action', '{{url('empresas/guardar')}}');
});

$('body').delegate('.editar_empresa, .detalle_empresa','click', function() {
    $('input.form-control').val('');
    id = $(this).parent().siblings("td:nth-child(2)").text(),
    nombre = $(this).parent().siblings("td:nth-child(3)").text(),
    oficina_cargo = $(this).parent().siblings("td:nth-child(4)").text(),
    direccion = $(this).parent().siblings("td:nth-child(5)").text(),
    contacto = $(this).parent().siblings("td:nth-child(6)").text(),
    telefono = $(this).parent().siblings("td:nth-child(7)").text(),
    marcacion_corta = $(this).parent().siblings("td:nth-child(8)").text(),
    contrato = $(this).parent().siblings("td:nth-child(9)").text(),
    numero_elementos = $(this).parent().siblings("td:nth-child(10)").text(),
    fecha_inicio = $(this).parent().siblings("td:nth-child(11)").text(),
    fecha_termino = $(this).parent().siblings("td:nth-child(12)").text(),
    observaciones = $(this).parent().siblings("td:nth-child(13)").text(),
    rfc = $(this).parent().siblings("td:nth-child(14)").text(),
    tipo_pago = $(this).parent().siblings("td:nth-child(15)").text(),

    $("form#form_empresa").get(0).setAttribute('action', '{{url('empresas/editar')}}');
    $("#formulario_empresa input#id").val(id);
    $("#formulario_empresa input#nombre").val(nombre);
    $("#formulario_empresa input#oficina_cargo").val(oficina_cargo);
    $("#formulario_empresa textarea#direccion").val(direccion);
    $("#formulario_empresa input#contacto").val(contacto);
    $("#formulario_empresa input#telefono").val(telefono);
    $("#formulario_empresa input#marcacion_corta").val(marcacion_corta);
    $("#formulario_empresa input#contrato").val(contrato);
    $("#formulario_empresa input#numero_elementos").val(numero_elementos);
    $("#formulario_empresa input#fecha_inicio").val(fecha_inicio);
    $("#formulario_empresa input#fecha_termino").val(fecha_termino);
    $("#formulario_empresa textarea#observaciones").val(observaciones);
    $("#formulario_empresa input#rfc").val(rfc);
    $("#formulario_empresa input#tipo_pago").val(tipo_pago);

    $("input#fecha_inicio").datepicker("update", fecha_inicio);
    $("input#fecha_termino").datepicker("update", fecha_termino);

            
    $('form#form_empresa input, form#form_empresa textarea').attr('disabled', $(this).hasClass('detalle_empresa') ? true : false);

    if ($(this).hasClass('detalle_empresa')) {
        $("h4#titulo_form_empresa").text('Detalle de empresa');
        $('form#form_empresa button.save').addClass('hide');
    } else {
        $("h4#titulo_form_empresa").text('Editar empresa');
        $('form#form_empresa button.save').removeClass('hide');
    }

    $('#formulario_empresa').modal();
});

/**
 *==================================================================================================================================================================================
 *=                                                           Empiezan las funciones relacionadas a la tabla de empresas                                                           =
 *==================================================================================================================================================================================
 */

$('body').delegate('.ver_servicios','click', function() {
    btn = $(this);
    empresa_id = $(this).parent().siblings("td:nth-child(2)").text();
    $('#nuevo_servicio').attr('empresa_id', empresa_id);
    btn.find('i.fa-spin').show();
    btn.attr('disabled', true);
    $('#form_servicios input.form-control').val('');
    $('#form_servicios div.form-group').removeClass('has-error');
    $("#form_servicios").get(0).setAttribute('action', "{{url('empresas/servicios/guardar')}}");

    cargarServicios(empresa_id, btn);
});

$('body').delegate('#nuevo_servicio, a[href="#tabNuevoServicio"]','click', function() {
    $("#form_servicios input#empresa_id").val($('#nuevo_servicio').attr('empresa_id'));
});

$('body').delegate('#nuevo_servicio','click', function() {
    $('#form_servicios input.form-control').val('');
    $('#form_servicios div.form-group').removeClass('has-error');
    $("#form_servicios").get(0).setAttribute('action', "{{url('empresas/servicios/guardar')}}");
    $("#form_servicios input#empresa_id").val($('#nuevo_servicio').attr('empresa_id'));
    $('a[href="#tabNuevoServicio"]').text('Nuevo servicio').tab('show');
});

$('body').delegate('button.editar_servicio','click', function() {
    $('#form_servicios div.form-group').removeClass('has-error');

    servicio_id = $(this).parent().siblings("td:nth-child(1)").text(),
    empresa_id = $(this).parent().siblings("td:nth-child(2)").text(),
    servicio = $(this).parent().siblings("td:nth-child(3)").text(),
    horario = $(this).parent().siblings("td:nth-child(4)").text(),
    sueldo = $(this).parent().siblings("td:nth-child(5)").text();
    sueldo_diario_guardia = $(this).parent().siblings("td:nth-child(6)").text();

    $("#form_servicios").get(0).setAttribute('action', "{{url('empresas/servicios/editar')}}");
    $("#form_servicios input#servicio_id").val(servicio_id);
    $("#form_servicios input#empresa_id").val(empresa_id);
    $("#form_servicios input#servicio").val(servicio);
    $("#form_servicios input#horario").val(horario);
    $("#form_servicios input#sueldo").val(sueldo);
    $("#form_servicios input#sueldo_diario_guardia").val(sueldo_diario_guardia);

    $('a[href="#tabNuevoServicio"]').text('Editar servicio').tab('show');
});

$('body').delegate('.eliminar_servicio','click', function() {
    var servicio_id = $(this).parent().siblings("td:nth-child(1)").text();
    var empresa_id = $(this).parent().siblings("td:nth-child(2)").text();

    swal({
        title: "¿Realmente desea eliminar el servicio con el ID <span style='color:#F8BB86'>" + servicio_id + "</span>?",
        text: "¡Cuidado, esta acción no podrá deshacerse!",
        html: true,
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, continuar",
        showLoaderOnConfirm: true,
        allowEscapeKey: true,
        allowOutsideClick: true,
        closeOnConfirm: false
    },
    function() {
        eliminarServicio(servicio_id,empresa_id);
    });
});
</script>
@endsection