<div class="row">
    <div class="col-md-12">
        @if ( count( $empleado->retenciones ) )
            <div id="opciones-adicionales">
                <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                <div>
                    <button class="btn btn-success exportar-excel-retenciones" data-row-id="{{$empleado->id}}"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar excel</button>
                </div>
            </div>
            <table class="table" id="empleado_retenciones">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Lugar</td>
                        <td>Importe</td>
                        <td>Rango de fechas</td>
                        <td>No. días</td>
                        <td>Comentarios</td>
                        <td>Fecha creación</td>
                        <td>Status</td>
                        @if ( auth()->user()->privilegios->emp_mod_prop == 1 )
                            <td>Acciones</td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach( $empleado->retenciones as $retencion )
                        <tr>
                            <td>{{$retencion->id}}</td>
                            <td>{{$retencion->empresa->nombre}}</td>
                            <td>${{$retencion->importe}}</td>
                            <td>{{date('d/M/Y', strtotime($retencion->fecha_inicio))}} - {{date('d/M/Y', strtotime($retencion->fecha_fin))}}</td>
                            <td>{{$retencion->num_dias}}</td>
                            <td>{{$retencion->comentarios}}</td>
                            <td>
                                {{strftime('%d', strtotime($retencion->created_at)).' de '.strftime('%B', strtotime($retencion->created_at)). ' del '.strftime('%Y', strtotime($retencion->created_at))}}
                            </td>
                            <td>
                                {!!
                                    ( $retencion->status == 0 ? "<span class='label label-danger'>Pendiente</span>" : 
                                        ( $retencion->status == 1 ? "<span class='label label-success'>Atendido</span>" : "<span class='label label-default'>Desconocido</span>" )
                                    )
                                !!}
                            </td>
                            @if ( auth()->user()->privilegios->emp_mod_prop == 1 )
                                <td>
                                    <button type="button" class="btn btn-danger eliminar_retencion" data-txt_msg="la retención" data-container_id="table_retenciones" data-route_fix="retenciones" data-row_id="{{$retencion->id}}">Eliminar</button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h5>No hay retenciones registradas para este empleado</h5>
        @endif
    </div>
</div>
            