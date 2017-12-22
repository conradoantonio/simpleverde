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
                    <td class="hide"><span>{{$empresa->status}}</span></td>
                    <td>
                        <button type="button" class="btn btn-info editar_empresa">Editar</button>
                        <button type="button" class="btn btn-success ver_servicios">
                                <i class="fa fa-spinner fa-spin" style="display: none"></i>
                                Servicios
                        </button>
                        <button type="button" class="btn btn-danger eliminar_empresa">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>