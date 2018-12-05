<table class="table" id="example3">
    <thead>
        <tr>
            <th></th>
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
                    <td class="small-cell v-align-middle">
                        <div class="checkbox check-success">
                            <input id="checkbox{{$pago->id}}" type="checkbox" class="checkDelete" value="1">
                            <label for="checkbox{{$pago->id}}"></label>
                        </div>
                    </td>
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
                        {{-- Marcar como pagado para cerrar lista --}}
                        @if( $pago->status == 2 && $modify == 1 )
                            <a href="{{url('pagar-nomina/'.$pago->id)}}" class="btn btn-success">Pagar</a>
                        @endif
                        {{-- Historial --}}
                        @if( $pago->status == 0 )
                        <a href="{{url('pagar-nomina/'.$pago->id)}}" class="btn btn-success">Ver hoja de pago</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>