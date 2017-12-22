<table class="table" id="example3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Empresa</th>
            <th>Intervalo fechas</th>
            <td>Estado</td>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if(count($pagos) > 0)
            @foreach($pagos as $pago)
                <tr class="" id="{{$pago->id}}">
                    <td>{{$pago->id}}</td>
                    <td>{{$pago->empresa->nombre}}</td>
                    <td>{{date('d/M/Y', strtotime($pago->fecha_inicio))}} - {{date('d/M/Y', strtotime($pago->fecha_fin))}}</td>

                    <td>
                        @if( $pago->status == 1 )
                            Asistencia
                        @elseif( $pago->status == 2 )
                            Pendiente a pagar
                        @else
                            Pagado
                        @endif
                    </td>
                    <td>
                        <a href="{{url('detalle-nomina/'.$pago->id)}}" class="btn btn-info editar_pago">Detalle</a>
                        @if($pago->status == 2 || $pago->status == 0)
                        <a href="{{url('pagar-nomina/'.$pago->id)}}" class="btn btn-success">{{$pago->status == 2 ? 'Pagar' : 'Ver hoja de pago'}}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>