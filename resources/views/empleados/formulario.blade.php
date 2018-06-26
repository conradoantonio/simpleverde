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
                            <form id="form-data" action="{{url('empleados')}}/{{ $empleado ? 'actualizar' : 'guardar' }}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table_container">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 hidden">
                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->id : ''}}" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="num_empleado" class="required">No. de empleado</label>
                                            <input type="text" class="form-control not-empty" value="{{$empleado ? $empleado->num_empleado : ''}}" id="num_empleado" name="num_empleado" placeholder="No. de empleado" data-msg="No. de empleado">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="nombre" class="required">Nombre</label>
                                            <input type="text" class="form-control not-empty" value="{{$empleado ? $empleado->nombre : ''}}" id="nombre" name="nombre" placeholder="Nombre" data-msg="Nombre">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="apellido_paterno" class="required">Apellido paterno</label>
                                            <input type="text" class="form-control not-empty" value="{{$empleado ? $empleado->apellido_paterno : ''}}" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido paterno" data-msg="Apellido paterno">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="apellido_materno" class="required">Apellido materno</label>
                                            <input type="text" class="form-control not-empty" value="{{$empleado ? $empleado->apellido_materno : ''}}" id="apellido_materno" name="apellido_materno" placeholder="Apellido materno" data-msg="Apellido materno">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="num_cuenta">No. de cuenta</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->num_cuenta : ''}}" id="num_cuenta" name="num_cuenta" maxlength="10" placeholder="No. de cuenta" data-msg="No. de cuenta">
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
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->telefono : ''}}" id="telefono" name="telefono" placeholder="Teléfono" data-msg="Teléfono">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="rfc">RFC</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->rfc : ''}}" id="rfc" name="rfc" placeholder="RFC" data-msg="RFC">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="curp">CURP</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->curp : ''}}" id="curp" name="curp" placeholder="CURP" data-msg="CURP">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="nss">NSS</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->nss : ''}}" id="nss" name="nss" placeholder="NSS" data-msg="NSS">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="telefono_emergencia">Télefono de emergencia</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->telefono_emergencia : ''}}" id="telefono_emergencia" name="telefono_emergencia" placeholder="Télefono de emergencia" data-msg="Télefono de emergencia">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="fecha_ingreso">Fecha de ingreso</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->fecha_ingreso : ''}}" id="fecha_ingreso" name="fecha_ingreso" placeholder="Fecha de ingreso">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="escolaridad">Escolaridad</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->escolaridad : ''}}" id="escolaridad" name="escolaridad" placeholder="Escolaridad">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="infonavit">Infonavit</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->infonavit : ''}}" id="infonavit" name="infonavit" placeholder="Infonavit">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="vacaciones">Vacaciones</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->vacaciones : ''}}" id="vacaciones" name="vacaciones" placeholder="Vacaciones">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="pensionado">Pensionado</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->pensionado : ''}}" id="pensionado" name="pensionado" placeholder="Pensionado">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="perfil_laboral">Perfil de comportamiento laboral</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->perfil_laboral : ''}}" id="perfil_laboral" name="perfil_laboral" placeholder="Perfil de comportamiento laboral">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="fecha_baja">Fecha de baja</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->fecha_baja : ''}}" id="fecha_baja" name="fecha_baja" placeholder="Fecha de baja">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="motivo_baja">Motivo de baja</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->motivo_baja : ''}}" id="motivo_baja" name="motivo_baja" placeholder="Motivo de baja">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="fecha_finiquito">Fecha de finiquito</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->fecha_finiquito : ''}}" id="fecha_finiquito" name="fecha_finiquito" placeholder="Fecha de finiquito">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="descripcion_finiquito">Descripción de finiquito</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->descripcion_finiquito : ''}}" id="descripcion_finiquito" name="descripcion_finiquito" placeholder="Descripción de finiquito">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="fecha_entrega_papeles">Fecha de entrega de papeles</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->fecha_entrega_papeles : ''}}" id="fecha_entrega_papeles" name="fecha_entrega_papeles" placeholder="Fecha de entrega de papeles">
                                        </div>
                                    </div>
                                     <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="entrega_papeles">Descripción de entrega de papeles</label>
                                            <input type="text" class="form-control" value="{{$empleado ? $empleado->entrega_papeles : ''}}" id="entrega_papeles" name="entrega_papeles" placeholder="Descripción de entrega de papeles">
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
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="cartilla_militar">Cartilla militar</label>
                                        <div class="checkbox check-primary">
                                            <input id="cartilla_militar" name="cartilla_militar" type="checkbox" {{($empleado ? ($empleado->documentacion->cartilla_militar ? 'checked' : '') : '')}}>
                                            <label for="cartilla_militar" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="licencia_conduccion">Licencia de conducir</label>
                                            <input type="text" class="form-control" value="{{$empleado && $empleado->documentacion ? $empleado->documentacion->licencia_conduccion : ''}}" id="licencia_conduccion" name="licencia_conduccion">
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

                                <hr>
                                <div class="row">
                                    <h3>Uniforme de empleado</h3>
                                    <div class="col-sm-6 col-xs-12 hide">
                                        <div class="form-group">
                                            <label for="uniforme_id">Uniforme ID</label>
                                            <input type="text" class="form-control" value="{{$empleado && $empleado->uniforme ? $empleado->uniforme->id : ''}}" id="uniforme_id" name="uniforme_id">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="playera_polo">Playera polo</label>
                                        <div class="checkbox check-primary">
                                            <input id="playera_polo" name="playera_polo" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->playera_polo ? 'checked' : '') : '')}}>
                                            <label for="playera_polo" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="camisa">Camisa</label>
                                        <div class="checkbox check-primary">
                                            <input id="camisa" name="camisa" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->camisa ? 'checked' : '') : '')}}>
                                            <label for="camisa" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="pantalones">Pantalones</label>
                                        <div class="checkbox check-primary">
                                            <input id="pantalones" name="pantalones" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->pantalones ? 'checked' : '') : '')}}>
                                            <label for="pantalones" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="chaleco">Chaleco</label>
                                        <div class="checkbox check-primary">
                                            <input id="chaleco" name="chaleco" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->chaleco ? 'checked' : '') : '')}}>
                                            <label for="chaleco" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="sueter">Sueter</label>
                                        <div class="checkbox check-primary">
                                            <input id="sueter" name="sueter" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->sueter ? 'checked' : '') : '')}}>
                                            <label for="sueter" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="chamarra">Chamarra</label>
                                        <div class="checkbox check-primary">
                                            <input id="chamarra" name="chamarra" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->chamarra ? 'checked' : '') : '')}}>
                                            <label for="chamarra" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="gorra">Gorra</label>
                                        <div class="checkbox check-primary">
                                            <input id="gorra" name="gorra" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->gorra ? 'checked' : '') : '')}}>
                                            <label for="gorra" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="botas">Botas</label>
                                        <div class="checkbox check-primary">
                                            <input id="botas" name="botas" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->botas ? 'checked' : '') : '')}}>
                                            <label for="botas" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="traje">Traje</label>
                                        <div class="checkbox check-primary">
                                            <input id="traje" name="traje" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->traje ? 'checked' : '') : '')}}>
                                            <label for="traje" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="corbata">Corbata</label>
                                        <div class="checkbox check-primary">
                                            <input id="corbata" name="corbata" type="checkbox" {{($empleado && $empleado->uniforme ? ($empleado->uniforme->corbata ? 'checked' : '') : '')}}>
                                            <label for="corbata" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="otros_uniformes">Otros</label>
                                            <input type="text" class="form-control" value="{{($empleado && $empleado->uniforme ? $empleado->uniforme->otros : '')}}" id="otros_uniformes" name="otros_uniformes" placeholder="Otros uniformes">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <h3>Aditamento de empleado</h3>
                                    <div class="col-sm-6 col-xs-12 hide">
                                        <div class="form-group">
                                            <label for="aditamento_id">Aditamento ID</label>
                                            <input type="text" class="form-control" value="{{$empleado && $empleado->aditamento ? $empleado->aditamento->id : ''}}" id="aditamento_id" name="aditamento_id">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="fornitura">Fornitura</label>
                                        <div class="checkbox check-primary">
                                            <input id="fornitura" name="fornitura" type="checkbox" {{($empleado && $empleado->aditamento ? ($empleado->aditamento->fornitura ? 'checked' : '') : '')}}>
                                            <label for="fornitura" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="tolete">Tolete</label>
                                        <div class="checkbox check-primary">
                                            <input id="tolete" name="tolete" type="checkbox" {{($empleado && $empleado->aditamento ? ($empleado->aditamento->tolete ? 'checked' : '') : '')}}>
                                            <label for="tolete" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="gas">Gas</label>
                                        <div class="checkbox check-primary">
                                            <input id="gas" name="gas" type="checkbox" {{($empleado && $empleado->aditamento ? ($empleado->aditamento->gas ? 'checked' : '') : '')}}>
                                            <label for="gas" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="aros_aprehensores">Aros aprehensores</label>
                                        <div class="checkbox check-primary">
                                            <input id="aros_aprehensores" name="aros_aprehensores" type="checkbox" {{($empleado && $empleado->aditamento ? ($empleado->aditamento->aros_aprehensores ? 'checked' : '') : '')}}>
                                            <label for="aros_aprehensores" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="radio">Radio</label>
                                        <div class="checkbox check-primary">
                                            <input id="radio" name="radio" type="checkbox" {{($empleado && $empleado->aditamento ? ($empleado->aditamento->radio ? 'checked' : '') : '')}}>
                                            <label for="radio" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="celular">Celular</label>
                                        <div class="checkbox check-primary">
                                            <input id="celular" name="celular" type="checkbox" {{($empleado && $empleado->aditamento ? ($empleado->aditamento->celular ? 'checked' : '') : '')}}>
                                            <label for="celular" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12" style="padding-bottom: 20px;">
                                        <label for="lampara">Lámpara</label>
                                        <div class="checkbox check-primary">
                                            <input id="lampara" name="lampara" type="checkbox" {{($empleado && $empleado->aditamento ? ($empleado->aditamento->lampara ? 'checked' : '') : '')}}>
                                            <label for="lampara" style="padding-left:0px;"></label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="otros_aditamentos">Otros</label>
                                            <input type="text" class="form-control" value="{{($empleado && $empleado->aditamento ? $empleado->aditamento->otros : '')}}" id="otros_aditamentos" name="otros_aditamentos" placeholder="Otros aditamentos">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{url('empleados')}}{{($empleado ? ($empleado->status == 0 ? '/inactivos' : '') : '')}}"><button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button></a>
                                @if($editable)
                                    <button type="submit" class="btn btn-primary save">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        Guardar
                                    </button>
                                @endif
                                @if($empleado)
                                    <a href="{{url("empleados/exportar/individual/1/$empleado->id")}}"><button type="button" class="btn btn-info" data-dismiss="modal">Exportar</button></a>
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
        //var empleado = '{{$empleado}}';
        console.log(editable);
        $('div#contenedor_empleados').fadeIn('low');
    }, 500)
</script>
@endsection