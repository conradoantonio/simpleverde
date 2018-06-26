@extends('admin.main')

@section('content')
{{-- <link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/> --}}
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style>
th {
    text-align: center!important;
}
/* Cambia el color de fondo de los input con autofill */
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset !important;
}
</style>
<div class="text-center" style="margin: 20px;">

    <h2>Lista de usuarios del panel</h2>

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <a href="{{url('usuarios/sistema/formulario')}}"><button type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo usuario (sistema)</button></a>
                    </div>
                    <div class="grid-body ">
                        <div class="table-responsive" id="tabla_usuarios_sistema">
                            @include('usuarios.usuariosSistema.table')
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
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/usuariosSistemaAjax.js') }}"></script>
<script src="{{ asset('js/validacionesUsuariosSistema.js') }}"></script>
<script type="text/javascript">
    $('body').delegate('.eliminar-usuario-sistema','click', function() {
        var usuario = $(this).parent().siblings("td:nth-child(2)").text();
        var token = $("#token").val();
        var id = $(this).parent().parent().attr('id');

        swal({
            title: "¿Realmente desea eliminar al usuario <span style='color:#F8BB86'>" + usuario + "</span>?",
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
            eliminarUsuarioSistema(id,token);
        });
    });
</script>
@endsection