@extends('admin.main')

@section('content')
<style type="text/css">
    textarea {
        resize: none;
    }
</style>
<div class="text-center" style="margin: 20px;">
    @if ($editable == 1)
        <h2>{{$usuario ? 'Editar' : 'Nuevo'}} Usuario</h2>
    @else
        <h2>Información de usuario</h2>
    @endif
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple form-container" style="display: none">
                <div class="grid-title">
                    <div class="grid-body">
                        <h3>Datos generales</h3>
                        <div class="container-fluid content-body">
                            <form id="form-data" action="{{url('usuarios/sistema')}}/{{ $usuario ? 'editar' : 'guardar' }}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="" data-container_id="">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 hidden">
                                        <div class="form-group">
                                            <label for="user_id">ID</label>
                                            <input type="text" class="form-control" value="{{$usuario ? $usuario->id : ''}}" id="user_id" name="user_id">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="username" class="required">Username</label>
                                            <input type="text" class="form-control not-empty" value="{{$usuario ? $usuario->user : ''}}" id="username" name="username" placeholder="Username" data-msg="Username">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 hide">
                                        <div class="form-group">
                                            <label for="username_old">Username (Old)</label>
                                            <input type="text" class="form-control" value="{{$usuario ? $usuario->user : ''}}" id="username_old" name="username_old" placeholder="Username (Old)" data-msg="Username (Old)">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="email" class="required">Email</label>
                                            <input type="text" class="form-control not-empty email" value="{{$usuario ? $usuario->email : ''}}" id="email" name="email" placeholder="Email" data-msg="Email">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="password" class="{{ $usuario ? '' : 'required'}}">Contraseña</label>
                                            <input type="password" class="form-control {{ $usuario ? '' : 'not-empty'}}" id="password" name="password" placeholder="Contraseña" data-msg="Contraseña">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h3>Privilegios</h3>

                                    {{-- Módulo de clientes --}}
                                    <h4>Clientes</h4>
                                    <div class="col-sm-6 col-xs-12 hide">
                                        <div class="form-group">
                                            <label for="privilegio_id">Privilegios ID</label>
                                            <input type="text" class="form-control" value="{{$usuario && $usuario->privilegios ? $usuario->privilegios->id : ''}}" id="privilegio_id" name="privilegio_id">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="cli_act">Clientes activos</label>
                                            <div class="checkbox check-primary">
                                                <input id="cli_act" name="cli_act" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->cli_act ? 'checked' : '') : '')}}>
                                                <label for="cli_act" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="cli_act_mod">Modificar clientes activos</label>
                                            <div class="checkbox check-primary">
                                                <input id="cli_act_mod" name="cli_act_mod" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->cli_act_mod ? 'checked' : '') : '')}}>
                                                <label for="cli_act_mod" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="cli_baj">Clientes inactivos</label>
                                            <div class="checkbox check-primary">
                                                <input id="cli_baj" name="cli_baj" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->cli_baj ? 'checked' : '') : '')}}>
                                                <label for="cli_baj" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="cli_baj_mod">Modificar clientes inactivos</label>
                                            <div class="checkbox check-primary">
                                                <input id="cli_baj_mod" name="cli_baj_mod" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->cli_baj_mod ? 'checked' : '') : '')}}>
                                                <label for="cli_baj_mod" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Módulo de empleados --}}
                                    <hr>
                                    <h4>Empleados</h4>
                                    <div class="row">
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="emp_act">Empleados activos</label>
                                            <div class="checkbox check-primary">
                                                <input id="emp_act" name="emp_act" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->emp_act ? 'checked' : '') : '')}}>
                                                <label for="emp_act" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="emp_act_mod">Modificar empleados activos</label>
                                            <div class="checkbox check-primary">
                                                <input id="emp_act_mod" name="emp_act_mod" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->emp_act_mod ? 'checked' : '') : '')}}>
                                                <label for="emp_act_mod" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="emp_baj">Empleados inactivos</label>
                                            <div class="checkbox check-primary">
                                                <input id="emp_baj" name="emp_baj" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->emp_baj ? 'checked' : '') : '')}}>
                                                <label for="emp_baj" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="emp_baj_mod">Modificar empleados inactivos</label>
                                            <div class="checkbox check-primary">
                                                <input id="emp_baj_mod" name="emp_baj_mod" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->emp_baj_mod ? 'checked' : '') : '')}}>
                                                <label for="emp_baj_mod" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <h4>Asistencias</h4>
                                    <div class="row">
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="asistencias">Asistencias</label>
                                            <div class="checkbox check-primary">
                                                <input id="asistencias" name="asistencias" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->asistencias ? 'checked' : '') : '')}}>
                                                <label for="asistencias" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="historial_asistencias">Historial de asistencias</label>
                                            <div class="checkbox check-primary">
                                                <input id="historial_asistencias" name="historial_asistencias" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->historial_asistencias ? 'checked' : '') : '')}}>
                                                <label for="historial_asistencias" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <h4>Usuarios</h4>
                                    <div class="row">
                                        <div class="col-sm-3 col-xs-12" style="padding-bottom: 20px;">
                                            <label for="usuarios">Usuarios</label>
                                            <div class="checkbox check-primary">
                                                <input id="usuarios" name="usuarios" type="checkbox" {{($usuario && $usuario->privilegios ? ($usuario->privilegios->usuarios ? 'checked' : '') : '')}}>
                                                <label for="usuarios" style="padding-left:0px;"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{url('usuarios/sistema')}}"><button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button></a>
                                @if($editable)
                                    <button type="submit" class="btn btn-primary save">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        Guardar
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script src="{{ asset('js/validacionesEmpleados.js') }}"></script> --}}
<script type="text/javascript">
    $(function(){
        $( "#fecha_ingreso, #fecha_baja, #fecha_finiquito, #fecha_entrega_papeles" ).datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm-dd",
        });
    })

    setTimeout(function() {
        var editable = <?php echo $editable;?>;
        if (editable == 0) {
            $('form#form-data input, form#form-data textarea').attr('disabled', true);
        }
        //var empleado = '{{$usuario}}';
        console.log(editable);
        
    }, 500)
</script>
@endsection