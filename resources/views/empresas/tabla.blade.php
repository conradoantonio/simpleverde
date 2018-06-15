<table class="table" id="example3">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
            <th>Oficina a cargo</th>
            <th class="">Dirección</th>
            <th class="">Contacto</th>
            <th class="">Teléfono</th>
            <th class="hide">Marcación corta</th>
            <th class="hide">Contrato</th>
            <th class="hide">Número de elementos</th>
            <th class="hide">Fecha inicio</th>
            <th class="hide">Fecha término</th>
            <th class="hide">Observaciones</th>
            <th class="hide">RFC</th>
            <th class="hide">Tipo de pago</th>
            <th class="hide">Status</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if (count($empresas) > 0)
            @foreach($empresas as $empresa)
                <tr class="" id="{{$empresa->id}}">
                    <td class="small-cell v-align-middle">
                        <div class="checkbox check-success">
                            <input id="checkbox{{$empresa->id}}" type="checkbox" class="checkDelete" value="1">
                            <label for="checkbox{{$empresa->id}}"></label>
                        </div>
                    </td>
                    <td>{{$empresa->id}}</td>
                    <td>{{$empresa->nombre}}</td>
                    <td class="text">{{$empresa->oficina_cargo}}</td>
                    <td class="text">{{$empresa->direccion}}</td>
                    <td class=""><span>{{$empresa->contacto}}</span></td>
                    <td class=""><span>{{$empresa->telefono}}</span></td>
                    <td class="hide"><span>{{$empresa->marcacion_corta}}</span></td>
                    <td class="hide"><span>{{$empresa->contrato}}</span></td>
                    <td class="hide"><span>{{$empresa->numero_elementos}}</span></td>
                    <td class="hide"><span>{{$empresa->fecha_inicio}}</span></td>
                    <td class="hide"><span>{{$empresa->fecha_termino}}</span></td>
                    <td class="hide"><span>{{$empresa->observaciones}}</span></td>
                    <td class="hide"><span>{{$empresa->rfc}}</span></td>
                    <td class="hide"><span>{{$empresa->tipo_pago}}</span></td>
                    <td class="hide"><span>{{$empresa->status}}</span></td>
                    <td>
                        <button type="button" class="btn btn-info editar_empresa">Editar</button>
                        <button type="button" class="btn btn-success detalle_empresa">Ver</button>
                        <button type="button" class="btn btn-warning ver_servicios">
                            <i class="fa fa-spinner fa-spin" style="display: none"></i>
                            Servicios
                        </button>
                        <a href="{{url("empresas/exportar/individual/1/$empresa->id")}}"><button type="button" class="btn btn-default" data-dismiss="modal"> Exportar</button></a>
                        <button type="button" change-to="{{$empresa->status == 1 ? 0 : 1}}" class="btn btn-danger {{$empresa->status == 1 ? 'disable-row' : 'enable-row'}}">{{$empresa->status == 1 ? 'Baja' : 'Reactivar'}}</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>