<table class="table" id="tabla_servicio">
    <thead>
        <tr>
            <th>ID</th>
            <th class="hide">Empresa ID</th>
            <th>Servicio</th>
            <th>Horario</th>
            <th>Sueldo</th>
            <th>Sueldo diario por guardia</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if (count($servicios) > 0)
            @foreach($servicios as $servicio)
                <tr class="" id="{{$servicio->id}}">
                    <td>{{$servicio->id}}</td>
                    <td class="hide">{{$servicio->empresa_id}}</td>
                    <td>{{$servicio->servicio}}</td>
                    <td>{{$servicio->horario}}</td>
                    <td>{{$servicio->sueldo}}</td>
                    <td>{{$servicio->sueldo_diario_guardia}}</td>
                    <td>
                        <button type="button" class="btn btn-info editar_servicio">Editar</button>
                        <button type="button" class="btn btn-danger eliminar_servicio">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>