<table class="table table-hover" id="example3">
    <thead class="centered">    
        <th class=>ID</th>
        <th>User</th>
        <th>Email</th>
        <th class="hide">Foto usuario</th>
        {{-- <th class="hide">Rol ID</th>
        <th class="">Rol</th> --}}
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
                    {{-- <td class="hide">{{$usuario->role->id}}</td>
                    <td class="">{{$usuario->role->rol}}</td> --}}
                    <td>{{$usuario->created_at}}</td>
                    <td>
                        <a href="{{url('usuarios/sistema/formulario')}}/{{$usuario->id}}"><button type="button" class="btn btn-info"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button></a>
                        <button type="button" class="btn btn-danger eliminar-usuario-sistema">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif  
    </tbody>
</table>