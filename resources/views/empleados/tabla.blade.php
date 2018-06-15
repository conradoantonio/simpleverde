<table class="table" id="example3">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
            <th class="">Apellido paterno</th>
            <th class="">Apellido materno</th>
            <th class="">No. Empleado</th>
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
                    <td>
                        <a href="{{url('empleados/formulario')}}/{{$empleado->id}}"><button type="button" class="btn btn-info editar_empleado">Editar</button></a>
                        <a href="{{url('empleados/detalle')}}/{{$empleado->id}}"><button type="button" class="btn btn-success detalle_empleado">Info</button></a>
                        <button type="button" change-to={{$empleado->status == 1 ? '0' : '1'}} class="btn btn-danger baja_empleado">{{$empleado->status == 1 ? 'Baja' : 'Reactivar'}}</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>