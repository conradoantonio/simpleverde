<div class="row">
    <div class="col-md-12">
        @if ( count( $empleado->deducciones ) )
            <div id="opciones-adicionales">
                <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                <div>
                    <button class="btn btn-success exportar-excel-deducciones" data-row-id="{{$empleado->id}}"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar excel</button>
                </div>
                <table class="table" id="empleado_deducciones">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Total a pagar</td>
                            <td>Número de pagos</td>
                            <td>Comentarios</td>
                            <td>Fecha creación</td>
                            @if ( auth()->user()->privilegios->emp_mod_prop == 1 )
                                <td>Acciones</td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $empleado->deducciones as $deduccion )
                            <tr>
                                <td>{{$deduccion->id}}</td>
                                <td>${{$deduccion->total}}</td>
                                <td>{{$deduccion->num_pagos}}</td>
                                <td>{{$deduccion->comentarios}}</td>
                                <td>
                                    {{strftime('%d', strtotime($deduccion->created_at)).' de '.strftime('%B', strtotime($deduccion->created_at)). ' del '.strftime('%Y', strtotime($deduccion->created_at))}}
                                </td>
                                @if ( auth()->user()->privilegios->emp_mod_prop == 1 )
                                    <td>
                                        <button type="button" class="btn btn-success detalle_deduccion" data-row-data="{{$deduccion->detalles}}">Detalles</button>
                                        <button type="button" class="btn btn-danger eliminar_deduccion" data-txt_msg="la deducción" data-container_id="table_deducciones" data-route_fix="deducciones" data-row_id="{{$deduccion->id}}">Eliminar</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h5>No hay deducciones registradas para este empleado</h5>
        @endif
    </div>
</div>
        