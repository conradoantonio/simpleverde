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

    <h2>Lista de empleados</h2>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="importar-excel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Importar empleados desde Excel</h4>
                </div>
                <form method="POST" onsubmit="return false" action="{{url('empleados/importar_empleados')}}" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                 <div class="alert alert-info alert-dismissible text-justify" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                    <strong>Instrucciones de uso: </strong><br>
                                    Para importar empleados a través de Excel, los datos deben estar acomodados como se describe a continuación: <br>
                                    Los campos de la primera fila de la hoja de excel deben de ir los campos llamados 
                                    <strong>"nombre, descripcion, precio, cantidad_porcion, precio_porcion, categoria, foto"</strong>, posteriormente, debajo de cada uno de estos campos deberán de ir los datos correspondientes de los empleados.
                                    <br><strong>Nota: </strong>
                                    <br>- Solo se aceptan archivos con extensión <kbd>xls y xlsx</kbd> y los empleados repetidos en el excel no serán creados.
                                    <br>- Esta acción puede llevar hasta 1 minuto, porfavor espere y permanezca en esta ventana hasta que un mensaje sea mostrado en su pantalla.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input class="form-control" type="file" id="archivo-excel" name="archivo-excel">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="enviar-excel">
                            Importar
                            <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        {{-- <button type="button" class="btn btn-info {{count($empleados) ? '' : 'hide'}}" id="exportar_empleados_excel"><i class="fa fa-download" aria-hidden="true"></i> Exportar empleados</button> --}}
                        <button type="button" class="btn btn-danger {{count($empleados) ? '' : 'hide'}}" id="eliminar_multiples_empleados"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar empleados</button>
                        
                        {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importar-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Importar empleados</button> --}}
                        <a href="{{url('empleados/formulario')}}"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formulario_empleado" id="nuevo_empleado"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo empleado</button></a>
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
{{-- <script src="{{ asset('js/empleadosAjax.js') }}"></script>
<script src="{{ asset('js/validacionesEmpleados.js') }}"></script> --}}
<script type="text/javascript">
/**
 *=============================================================================================================================================
 *=                                        Empiezan las funciones relacionadas a la tabla de empleados                                        =
 *=============================================================================================================================================
 */

$('#formulario_empleado').on('hidden.bs.modal', function (e) {
    $('#formulario_empleado div.form-group').removeClass('has-error');
    $('input.form-control, textarea.form-control').val('');
    $("#formulario_empleado input#oferta").prop('checked', false);
});

$('body').delegate('#eliminar_multiples_empleados','click', function() {
    var checking = [];
    $("input.checkDelete").each(function() {
        if($(this).is(':checked')) {
            checking.push($(this).parent().parent().parent().attr('id'));
        }
    });
    if (checking.length > 0) {
        swal({
            title: "¿Realmente desea eliminar las <span style='color:#F8BB86'>" + checking.length + "</span> empleados seleccionadas?",
            text: "¡Esta acción no podrá deshacerse!",
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
            var token = $("#token").val();
            eliminarMultiplesEmpleados(checking, token);
        });
    }
});

$('body').delegate('.eliminar_empleado','click', function() {
    var nombre = $(this).parent().siblings("td:nth-child(3)").text();
    var token = $("#token").val();
    var id = $(this).parent().parent().attr('id');

    swal({
        title: "¿Realmente desea eliminar la empleado <span style='color:#F8BB86'>" + nombre + "</span>?",
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
        eliminarEmpleado(id,token);
    });
});

</script>
@endsection