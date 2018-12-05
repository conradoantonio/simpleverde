<div class="row">
    <div class="col-md-12">
        @if ( count( $empleado->conceptos ) )
            <div id="opciones-adicionales">
                <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                <div>
                    <button class="btn btn-success exportar-excel-conceptos" data-row-id="{{$empleado->id}}"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar excel</button>
                </div>
            </div>
            <table class="table" id="empleado_conceptos">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Importe</td>
                        <td>Comentarios</td>
                        <td>Fecha creación</td>
                        <td>Status</td>
                        @if ( auth()->user()->privilegios->emp_mod_prop == 1 )
                            <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach( $empleado->conceptos as $concepto )
                        <tr>
                            <td>{{$concepto->id}}</td>
                            <td>${{$concepto->importe}}</td>
                            <td>{{$concepto->comentarios}}</td>
                            <td>
                                {{strftime('%d', strtotime($concepto->created_at)).' de '.strftime('%B', strtotime($concepto->created_at)). ' del '.strftime('%Y', strtotime($concepto->created_at))}}
                            </td>
                            <td>
                                {!!
                                    ( $concepto->status == 0 ? "<span class='label label-danger'>Pendiente</span>" : 
                                        ( $concepto->status == 1 ? "<span class='label label-success'>Atendido</span>" : "<span class='label label-default'>Desconocido</span>" )
                                    )
                                !!}
                            </td>
                            @if ( auth()->user()->privilegios->emp_mod_prop == 1 )
                                <td>
                                    <button type="button" class="btn btn-danger eliminar_concepto" data-txt_msg="el concepto" data-container_id="table_conceptos" data-route_fix="conceptos" data-row_id="{{$concepto->id}}">Eliminar</button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h5>No hay conceptos registrados para este empleado</h5>
        @endif
    </div>
</div>
            