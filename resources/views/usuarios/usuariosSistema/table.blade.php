<table class="table table-hover" id="example3">
    <thead class="centered">    
        <th class=>ID</th>
        <th>User</th>
        <th>Email</th>
        <th class="hide">Foto usuario</th>
        <th class="hide">Tipo num</th>
        <th class="">Tipo</th>
        <th>Fecha registro</th>
        <th>Acciones</th>
    </thead>
    <tbody id="tabla-usuarios-sistema" class="">
        @if(count($usuarios) > 0)                           
            @foreach($usuarios as $usuario)
                <tr class="" id="{{$usuario->id}}">
                    <td>{{$usuario->id}}</td>
                    <td>{{$usuario->user}}</td>
                    <td>{{$usuario->email}}</td>
                    <td class="hide">{{$usuario->foto_usuario}}</td>
                    <td class="hide">{{$usuario->type}}</td>
                    <td class="">{{($usuario->type == 1 ? 'Administrador' : ($usuario->type == 2 ? 'Nómina' : ($usuario->type == 3 ? 'Supervisor' : 'Desconocido')))}}</td>
                    <td>{{$usuario->created_at}}</td>
                    <td>
                        <button type="button" class="btn btn-info editar-usuario">Editar</button>
                        <button type="button" class="btn btn-danger eliminar-usuario-sistema">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif  
    </tbody>
</table>