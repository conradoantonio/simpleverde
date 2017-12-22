<table class="table" id="example3">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
            <th class="">Apellido</th>
            <th class="">No. Empleado</th>
            <th class="hide">Domicilio</th>
            <th class="hide">Ciudad</th>
            <th class="hide">Teléfono</th>
            <th class="hide">RFC</th>
            <th class="hide">CURP</th>
            <th class="hide">nss</th>
            <th class="hide">Teléfono de emergencia</th>
            <th class="hide">Status</th>

            <th class="hide">Empleado id</th>
            <th class="hide">Doc. Comprobante de domicilio</th>
            <th class="hide">Doc. Identificación</th>
            <th class="hide">Doc. CURP</th>
            <th class="hide">Doc. RFC</th>
            <th class="hide">Doc. Hoja del IMSS</th>
            <th class="hide">Doc. Carta de no antecedentes penales</th>
            <th class="hide">Doc. Acta de nacimiento</th>
            <th class="hide">Doc. Comprobante de estudios</th>
            <th class="hide">Doc. Resultado de psicometrías</th>
            <th class="hide">Doc. Examen de socieconómico</th>
            <th class="hide">Doc. Examen de toxicológico</th>

            <th class="hide">Doc. Solicitud frente y vuelta</th>
            <th class="hide">Doc. Depósito de uniforme</th>
            <th class="hide">Doc. Constancia de recepción de uniforme</th>
            <th class="hide">Doc. Comprobante_recepcion_reglamento_interno_trabajo</th>
            <th class="hide">Doc. Autorizacion_pago_tarjeta</th>
            <th class="hide">Doc. Carta de aceptacion de cambio de lugar</th>
            <th class="hide">Doc. Finiquito</th>
            <th class="hide">Doc. Calendario</th>
            <th class="hide">Doc. Formato de datos personales</th>
            <th class="hide">Doc. Solicitud de autorización de consulta</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if(count($empleados) > 0)
            @foreach($empleados as $empleado)
                <tr class="" id="{{$empleado->id}}">
                    <td class="small-cell v-align-middle">
                        <div class="checkbox check-success">
                            <input id="checkbox{{$empleado->id}}" type="checkbox" class="checkDelete" value="1">
                            <label for="checkbox{{$empleado->id}}"></label>
                        </div>
                    </td>
                    <td>{{$empleado->id}}</td>
                    <td>{{$empleado->nombre}}</td>
                    <td class="text">{{$empleado->apellido}}</td>
                    <td class="">{{$empleado->num_empleado}}</td>
                    <td class="hide">{{$empleado->domicilio}}</td>
                    <td class="hide">{{$empleado->ciudad}}</td>
                    <td class="hide">{{$empleado->telefono}}</td>
                    <td class="hide">{{$empleado->rfc}}</td>
                    <td class="hide">{{$empleado->curp}}</td>
                    <td class="hide">{{$empleado->nss}}</td>
                    <td class="hide">{{$empleado->telefono_emergencia}}</td>
                    <td class="hide">{{$empleado->status}}</td>

                    <td class="hide">{{$empleado->documentacion->empleado_id}}</td>
                    <td class="hide">{{$empleado->documentacion->comprobante_domicilio}}</td>
                    <td class="hide">{{$empleado->documentacion->identificacion}}</td>
                    <td class="hide">{{$empleado->documentacion->curp}}</td>
                    <td class="hide">{{$empleado->documentacion->rfc}}</td>
                    <td class="hide">{{$empleado->documentacion->hoja_imss}}</td>
                    <td class="hide">{{$empleado->documentacion->carta_no_antecedentes_penales}}</td>
                    <td class="hide">{{$empleado->documentacion->acta_nacimiento}}</td>
                    <td class="hide">{{$empleado->documentacion->comprobante_estudios}}</td>
                    <td class="hide">{{$empleado->documentacion->resultado_psicometrias}}</td>
                    <td class="hide">{{$empleado->documentacion->examen_socieconomico}}</td>
                    <td class="hide">{{$empleado->documentacion->examen_toxicologico}}</td>

                    <td class="hide">{{$empleado->documentacion->solicitud_frente_vuelta}}</td>
                    <td class="hide">{{$empleado->documentacion->deposito_uniforme}}</td>
                    <td class="hide">{{$empleado->documentacion->constancia_recepcion_uniforme}}</td>
                    <td class="hide">{{$empleado->documentacion->comprobante_recepcion_reglamento_interno_trabajo}}</td>
                    <td class="hide">{{$empleado->documentacion->autorizacion_pago_tarjeta}}</td>
                    <td class="hide">{{$empleado->documentacion->carta_aceptacion_cambio_lugar}}</td>
                    <td class="hide">{{$empleado->documentacion->finiquito}}</td>
                    <td class="hide">{{$empleado->documentacion->calendario}}</td>
                    <td class="hide">{{$empleado->documentacion->formato_datos_personales}}</td>
                    <td class="hide">{{$empleado->documentacion->solicitud_autorizacion_consulta}}</td>
                    <td>
                        <a href="{{url('empleados/formulario')}}/{{$empleado->id}}"><button type="button" class="btn btn-info editar_empleado">Editar</button></a>
                        <a href="{{url('empleados/detalle')}}/{{$empleado->id}}"><button type="button" class="btn btn-success detalle_empleado">Info</button></a>
                        <button type="button" class="btn btn-danger eliminar_empleado">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>