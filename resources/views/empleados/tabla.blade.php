<table class="table" id="example3">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
            <th class="">Apellido paterno</th>
            <th class="">Apellido materno</th>
            <th class="">No. Empleado</th>
            <th class="">Deducciones</th>
            <th class="">Pagado</th>
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
                    <td class="text">{{$empleado->apellido_paterno}}</td>
                    <td class="text">{{$empleado->apellido_materno}}</td>
                    <td class="">{{$empleado->num_empleado}}</td>
                    <td class="">${{$empleado->deducciones->sum('total')}}</td>
                    <td class="">
                        <?php $cont = 0; ?>
                        @if (count($empleado->deducciones) )
                            @foreach($empleado->deducciones as $deduccion)
                                @foreach($deduccion->detalles as $detalle)
                                    @if ($detalle->status == 1)
                                        <?php $cont += $detalle->cantidad; ?>
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                        ${{$cont}}
                    </td>
                    <td>
                        <a href="{{url('empleados/detalle')}}/{{$empleado->id}}"><button type="button" class="btn btn-success detalle_empleado">Info</button></a>
                        @if ( $modify == 1 )
                            <a href="{{url('empleados/formulario')}}/{{$empleado->id}}"><button type="button" class="btn btn-info editar_empleado">Editar</button></a>
                            <button type="button" class="btn btn-primary agregar_deduccion">Deducir</button>
                            <button type="button" class="btn btn-warning agregar_retencion">Retener</button>
                            <button type="button" change-to={{$empleado->status == 1 ? '0' : '1'}} class="btn btn-danger baja_empleado">{{$empleado->status == 1 ? 'Baja' : 'Reactivar'}}</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>