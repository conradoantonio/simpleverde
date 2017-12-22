@extends('admin.main')

@section('content')
<style type="text/css">
    textarea {
        resize: none;
    }
</style>
<div class="text-center" style="margin: 20px;">
    @if ($editable == 1)
        <h2>{{$empleado ? 'Editar' : 'Nuevo'}} Empleado</h2>
    @else
        <h2>Información de empleado</h2>
    @endif
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple" style="display: none" id="contenedor_empleados">
                <div class="grid-title">
                    <div class="grid-body">
                        <h3>Datos generales</h3>
                    	<div class="container-fluid content-body">
                            <form id="form_empleado" action="{{url('empleados')}}/{{ $empleado ? 'actualizar' : 'guardar' }}" enctype="multipart/form-data" method="POST" autocomplete="off">
                                <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 hidden">
                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->id : ''}}" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->nombre : ''}}" id="nombre" name="nombre" placeholder="Nombre">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="apellido">Apellido</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->apellido : ''}}" id="apellido" name="apellido" placeholder="Apellido">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="num_empleado">No. de empleado</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->num_empleado : ''}}" id="num_empleado" name="num_empleado" placeholder="No. de empleado">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="num_cuenta">No. de cuenta</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->num_cuenta : ''}}" id="num_cuenta" name="num_cuenta" maxlength="10" placeholder="No. de cuenta">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="domicilio">Domicilio</label>
                                            <textarea class="form-control" rows="3" id="domicilio" name="domicilio" placeholder="Domicilio">{{$empleado ? $empleado->domicilio : ''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="ciudad">Ciudad</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->ciudad : ''}}" id="ciudad" name="ciudad" placeholder="Ciudad">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->telefono : ''}}" id="telefono" name="telefono" placeholder="Teléfono">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="rfc">RFC</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->rfc : ''}}" id="rfc" name="rfc" placeholder="RFC">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="curp">CURP</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->curp : ''}}" id="curp" name="curp" placeholder="CURP">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="nss">NSS</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->nss : ''}}" id="nss" name="nss" placeholder="NSS">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="telefono_emergencia">Télefono de emergencia</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->telefono_emergencia : ''}}" id="telefono_emergencia" name="telefono_emergencia" placeholder="Télefono de emergencia">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <h3>Documentación</h3>
                                    <div class="col-sm-6 col-xs-12 hidden">
                                        <div class="form-group">
                                            <label for="empleado_id">Empleado ID</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->documentacion->empleado_id : ''}}" id="empleado_id" name="empleado_id">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 hidden">
                                        <div class="form-group">
                                            <label for="documentacion_id">Empleado ID</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->documentacion->id : ''}}" id="documentacion_id" name="documentacion_id">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="comprobante_domicilio">Comprobante de domicilio</label>
                                        <div class="checkbox check-primary">
                                            <input id="comprobante_domicilio" name="comprobante_domicilio" type="checkbox" {{($empleado ? ($empleado->documentacion->comprobante_domicilio ? 'checked' : '') : '')}}>
                                            <label for="comprobante_domicilio" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="identificacion">Identificación</label>
                                        <div class="checkbox check-primary">
                                            <input id="identificacion" name="identificacion" type="checkbox" {{($empleado ? ($empleado->documentacion->identificacion ? 'checked' : '') : '')}}>
                                            <label for="identificacion" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="curp_documento">CURP</label>
                                        <div class="checkbox check-primary">
                                            <input id="curp_documento" name="curp_documento" type="checkbox" {{($empleado ? ($empleado->documentacion->curp ? 'checked' : '') : '')}}>
                                            <label for="curp_documento" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="rfc_documento">RFC</label>
                                        <div class="checkbox check-primary">
                                            <input id="rfc_documento" name="rfc_documento" type="checkbox" {{($empleado ? ($empleado->documentacion->rfc ? 'checked' : '') : '')}}>
                                            <label for="rfc_documento" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="hoja_imss">Hoja del IMSS</label>
                                        <div class="checkbox check-primary">
                                            <input id="hoja_imss" name="hoja_imss" type="checkbox" {{($empleado ? ($empleado->documentacion->hoja_imss ? 'checked' : '') : '')}}>
                                            <label for="hoja_imss" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="carta_no_antecedentes_penales">Carta de no antecedentes penales</label>
                                        <div class="checkbox check-primary">
                                            <input id="carta_no_antecedentes_penales" name="carta_no_antecedentes_penales" type="checkbox" {{($empleado ? ($empleado->documentacion->carta_no_antecedentes_penales ? 'checked' : '') : '')}}>
                                            <label for="carta_no_antecedentes_penales" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="acta_nacimiento">Acta de nacimiento</label>
                                        <div class="checkbox check-primary">
                                            <input id="acta_nacimiento" name="acta_nacimiento" type="checkbox" {{($empleado ? ($empleado->documentacion->acta_nacimiento ? 'checked' : '') : '')}}>
                                            <label for="acta_nacimiento" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="comprobante_estudios">Comprobante de estudios</label>
                                        <div class="checkbox check-primary">
                                            <input id="comprobante_estudios" name="comprobante_estudios" type="checkbox" {{($empleado ? ($empleado->documentacion->comprobante_estudios ? 'checked' : '') : '')}}>
                                            <label for="comprobante_estudios" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="resultado_psicometrias">Resultados de psicometrías</label>
                                        <div class="checkbox check-primary">
                                            <input id="resultado_psicometrias" name="resultado_psicometrias" type="checkbox" {{($empleado ? ($empleado->documentacion->resultado_psicometrias ? 'checked' : '') : '')}}>
                                            <label for="resultado_psicometrias" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="examen_socieconomico">Examen socioeconómico</label>
                                        <div class="checkbox check-primary">
                                            <input id="examen_socieconomico" name="examen_socieconomico" type="checkbox" {{($empleado ? ($empleado->documentacion->examen_socieconomico ? 'checked' : '') : '')}}>
                                            <label for="examen_socieconomico" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="examen_toxicologico">Examen toxicológico</label>
                                        <div class="checkbox check-primary">
                                            <input id="examen_toxicologico" name="examen_toxicologico" type="checkbox" {{($empleado ? ($empleado->documentacion->examen_toxicologico ? 'checked' : '') : '')}}>
                                            <label for="examen_toxicologico" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="row">
                                    <h3>Solicitud</h3>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="solicitud_frente_vuelta">Solicitud frente y vuelta</label>
                                        <div class="checkbox check-primary">
                                            <input id="solicitud_frente_vuelta" name="solicitud_frente_vuelta" type="checkbox" {{($empleado ? ($empleado->documentacion->solicitud_frente_vuelta ? 'checked' : '') : '')}}>
                                            <label for="solicitud_frente_vuelta" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="deposito_uniforme">Depósito de uniforme</label>
                                        <div class="checkbox check-primary">
                                            <input id="deposito_uniforme" name="deposito_uniforme" type="checkbox" {{($empleado ? ($empleado->documentacion->deposito_uniforme ? 'checked' : '') : '')}}>
                                            <label for="deposito_uniforme" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="constancia_recepcion_uniforme">Constancia de recepción de uniforme</label>
                                        <div class="checkbox check-primary">
                                            <input id="constancia_recepcion_uniforme" name="constancia_recepcion_uniforme" type="checkbox" {{($empleado ? ($empleado->documentacion->constancia_recepcion_uniforme ? 'checked' : '') : '')}}>
                                            <label for="constancia_recepcion_uniforme" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="comprobante_recepcion_reglamento_interno_trabajo">Comprobante de recepción del reglamento interno de trabajo</label>
                                        <div class="checkbox check-primary">
                                            <input id="comprobante_recepcion_reglamento_interno_trabajo" name="comprobante_recepcion_reglamento_interno_trabajo" type="checkbox" {{($empleado ? ($empleado->documentacion->comprobante_recepcion_reglamento_interno_trabajo ? 'checked' : '') : '')}}>
                                            <label for="comprobante_recepcion_reglamento_interno_trabajo" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="autorizacion_pago_tarjeta">Autorización para pago con tarjeta</label>
                                        <div class="checkbox check-primary">
                                            <input id="autorizacion_pago_tarjeta" name="autorizacion_pago_tarjeta" type="checkbox" {{($empleado ? ($empleado->documentacion->autorizacion_pago_tarjeta ? 'checked' : '') : '')}}>
                                            <label for="autorizacion_pago_tarjeta" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="carta_aceptacion_cambio_lugar">Carta de aceptación por cambio de lugar</label>
                                        <div class="checkbox check-primary">
                                            <input id="carta_aceptacion_cambio_lugar" name="carta_aceptacion_cambio_lugar" type="checkbox" {{($empleado ? ($empleado->documentacion->carta_aceptacion_cambio_lugar ? 'checked' : '') : '')}}>
                                            <label for="carta_aceptacion_cambio_lugar" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="finiquito">Finiquito</label>
                                        <div class="checkbox check-primary">
                                            <input id="finiquito" name="finiquito" type="checkbox" {{($empleado ? ($empleado->documentacion->finiquito ? 'checked' : '') : '')}}>
                                            <label for="finiquito" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="calendario">Calendario</label>
                                        <div class="checkbox check-primary">
                                            <input id="calendario" name="calendario" type="checkbox" {{($empleado ? ($empleado->documentacion->calendario ? 'checked' : '') : '')}}>
                                            <label for="calendario" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="formato_datos_personales">Formato de datos personales</label>
                                        <div class="checkbox check-primary">
                                            <input id="formato_datos_personales" name="formato_datos_personales" type="checkbox" {{($empleado ? ($empleado->documentacion->formato_datos_personales ? 'checked' : '') : '')}}>
                                            <label for="formato_datos_personales" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="solicitud_autorizacion_consulta">Solicitud de autorización de consulta</label>
                                        <div class="checkbox check-primary">
                                            <input id="solicitud_autorizacion_consulta" name="solicitud_autorizacion_consulta" type="checkbox" {{($empleado ? ($empleado->documentacion->solicitud_autorizacion_consulta ? 'checked' : '') : '')}}>
                                            <label for="solicitud_autorizacion_consulta" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                </div>
                                @if ($editable)
                                    <button type="submit" class="btn btn-primary" id="guardar_empleado">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        Guardar
                                    </button>
                                @endif
                                <a href="{{url('empleados')}}"><button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button></a>
                            </form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script src="{{ asset('js/empleadosAjax.js') }}"></script> --}}
<script src="{{ asset('js/validacionesEmpleados.js') }}"></script>
<script type="text/javascript">
    setTimeout(function() {
        var editable = <?php echo $editable;?>;
        if (editable == 0) {
            $('form#form_empleado input, form#form_empleado textarea').attr('disabled', true);
        }
        //var empleado = '{{$empleado}}';
        console.log(editable);
        $('div#contenedor_empleados').fadeIn('low');
    }, 500)
</script>
@endsection