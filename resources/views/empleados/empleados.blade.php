@extends('admin.main')

@section('content')
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

    <h2>Lista de empleados</h2>

    @include('empleados.modal')

    <div class="row-fluid" style="display: none">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <button type="button" data-redirect="{{url("empleados/exportar/general/{$status}")}}" class="btn btn-info export_excel {{count($empleados) ? '' : 'hide'}}" id="exportar_empleados_excel"><i class="fa fa-download" aria-hidden="true"></i> Exportar empleados</button>
                        <button type="button" data-redirect="{{url("deducciones/excel/export/general/{$status}")}}" class="btn btn-primary export_excel {{count($empleados) ? '' : 'hide'}}" id="exportar_deducciones"><i class="fa fa-download" aria-hidden="true"></i> Exportar deducciones</button>
                        <button type="button" data-redirect="{{url("retenciones/excel/export/general/{$status}")}}" class="btn btn-warning export_excel {{count($empleados) ? '' : 'hide'}}" id="exportar_retenciones"><i class="fa fa-download" aria-hidden="true"></i> Exportar retenciones</button>
                        @if($modify == 1)
                            <button type="button" class="btn btn-danger {{count($empleados) ? '' : 'hide'}}" id="dar_baja_empleados"><i class="fa {{$status == 1 ? 'fa-trash' : 'fa-undo'}}" aria-hidden="true"></i> {{$status == 1 ? 'Dar de baja' : 'Reactivar empleados'}}</button>
                        @endif

                        @if($status == 1 && $modify == 1)
                            <a href="{{url('empleados/formulario')}}"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#formulario_empleado" id="nuevo_empleado"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo empleado</button></a>
                        @endif
                    </div>
                    <div class="grid-body">
                        <div class="table-responsive" id="div_tabla_empleados">
                            @include('empleados.tabla')
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
<script src="{{ asset('js/empleadosAjax.js') }}"></script>
<script type="text/javascript">
/**
 *=============================================================================================================================================
 *=                                        Empiezan las funciones relacionadas a la tabla de empleados                                        =
 *=============================================================================================================================================
 */
$(function(){
    global_status = <?php echo $status;?>;
    swal_msg = global_status == 1 ? 'dar de baja' : 'reactivar';
    activar = global_status == 1 ? 0 : 1;

    $(".select2").select2();

    $( "input[name='fecha_inicio'" ).datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
    }).on( "changeDate", function(e) {
        $( "input[name='fecha_fin']" ).setStartDate = e.date;
    });

    $( "input[name='fecha_fin']" ).datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
    }).on( "changeDate", function(e) {
        $( "input[name='fecha_inicio'" ).setEndDate = e.date;
    });
})

$('#formulario_empleado').on('hidden.bs.modal', function (e) {
    $('#formulario_empleado div.form-group').removeClass('has-error');
    $('input.form-control, textarea.form-control').val('');
    $("#formulario_empleado input#oferta").prop('checked', false);
});

$('body').delegate('#dar_baja_empleados','click', function() {
    var checking = [];
    $("input.checkDelete").each(function() {
        if($(this).is(':checked')) {
            checking.push($(this).parent().parent().parent().attr('id'));
        }
    });
    if (checking.length > 0) {
        swal({
            title: "¿Realmente desea "+ swal_msg +" los <span style='color:#F8BB86'>" + checking.length + "</span> empleados seleccionadas?",
            text: "¡Cuidado!",
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
            darBajaMultiplesEmpleados(checking, activar);
        });
    }
});

$('body').delegate('.baja_empleado','click', function() {
    var nombre = $(this).parent().siblings("td:nth-child(3)").text();
    var id = $(this).parent().parent().attr('id');
    swal({
        title: "¿Realmente desea " + swal_msg + " el empleado <span style='color:#F8BB86'>" + nombre + "</span>?",
        text: "¡Cuidado!",
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
        bajaEmpleado(id, activar);
    });
});

$('body').delegate('.agregar_deduccion','click', function() {
    var id = $(this).parent().parent().attr('id');

    $("form#form-deducciones input[name='empleado_id']").val(id);
    
    $('div#md-deducciones').modal();
});

$('body').delegate('.agregar_retencion','click', function() {
    var id = $(this).parent().parent().attr('id');

    $("form#form-retenciones input[name='empleado_id']").val(id);

    $('div#md-retenciones').modal();
});

$('body').delegate('.agregar_concepto','click', function() {
    var id = $(this).parent().parent().attr('id');

    $("form#form-conceptos input[name='empleado_id']").val(id);

    $('div#md-conceptos').modal();
});

$('body').delegate('.export_excel','click', function() {
    var redirect = $(this).data('redirect');

    window.location.href = redirect;
});

</script>
@endsection