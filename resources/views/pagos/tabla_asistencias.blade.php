<table class="table table-bordered table-responsive" id="nomina">
	<thead>
		<th></th>
		<th>ID</th>
		<th>No. Empleado</th>
		<th>Nombre</th>
		@foreach( $dias as $day )
			@if( $day['dia'] == 0 )
				<th class="{{$day['edit']?'edit':''}}">
					<h6>D</h6>
					<h6>{{$day['num']}}</h6>
				</th>
			@elseif( $day['dia'] == 1 )
				<th class="{{$day['edit']?'edit':''}}">
					<h6>L</h6>
					<h6>{{$day['num']}}</h6>
				</th>
			@elseif( $day['dia'] == 2 )
				<th class="{{$day['edit']?'edit':''}}">
					<h6>M</h6>
					<h6>{{$day['num']}}</h6>
				</th>
			@elseif( $day['dia'] == 3 )
				<th class="{{$day['edit']?'edit':''}}">
					<h6>M</h6>
					<h6>{{$day['num']}}</h6>
				</th>
			@elseif( $day['dia'] == 4 )
				<th class="{{$day['edit']?'edit':''}}">
					<h6>J</h6>
					<h6>{{$day['num']}}</h6>
				</th>
			@elseif( $day['dia'] == 5 )
				<th class="{{$day['edit']?'edit':''}}">
					<h6>V</h6>
					<h6>{{$day['num']}}</h6>
				</th>
			@else
				<th class="{{$day['edit']?'edit':''}}">
					<h6>S</h6>
					<h6>{{$day['num']}}</h6>
				</th>
			@endif
		@endforeach
		<th>Notas</th>
		<th>Deducciones</th>
		<th>Retenciones</th>
		@if ( $pago->status != 0 ) {{-- Mientras no sea historial... --}}
			<th>Acciones</th>
		@endif
	</thead>
	<tbody>
		@foreach( $pago->PagoUsuarios as $trabajador )
			<tr>
				<td class="small-cell v-align-middle">
                    <div class="checkbox check-success">
                        <input id="checkbox{{$trabajador->id}}" type="checkbox" class="checkDelete" value="1">
                        <label for="checkbox{{$trabajador->id}}"></label>
                    </div>
                </td>
				<td>{{$trabajador->usuarios->id}}</td>
				<td>{{$trabajador->usuarios->num_empleado}}</td>
				<td data-user={{$trabajador->usuarios->id}} data-realid={{$pago->id}} data-pago={{$trabajador->id}}>{{$trabajador->usuarios->nombre}} {{$trabajador->usuarios->apellido_paterno}} {{$trabajador->usuarios->apellido_materno}}</td>
				@if ( count($asistencias) == 0 )
    				@foreach ( $dias as $day )
						<td class="cell" data-dia="{{$day['num']}}"></td>
					@endforeach
				@else
					@foreach ( $asistencias as $asistencia )
						@if ( $asistencia->pago->id == $trabajador->id )
							<td class="cell" data-dia="{{$asistencia->dia}}">{{$asistencia->status}}</td>
						@endif
					@endforeach
				@endif
				<td data-notes="1"><input type="text" name="notas" value="{{$trabajador->notas?$trabajador->notas:''}}"></td>
				<td>${{$trabajador->deducciones_detalles->sum('cantidad')}}</td>
				<td>${{$trabajador->retenciones->sum('importe')}}</td>
				@if ( $pago->status != 0 ) {{-- Mientras no sea historial... --}}
					<td>
	                    <button type="button" class="btn btn-mini btn-primary pagar_deduccion" data-empleado_id="{{$trabajador->usuarios->id}}" data-usuario_pago_id={{$trabajador->id}} data-toggle="tooltip" data-placement="top" data-title="Adjuntar deducción"><i class="fa fa-money"></i></button>
	                    <button type="button" class="btn btn-mini btn-danger reiniciar_deduccion" data-empleado_id="{{$trabajador->usuarios->id}}" data-usuario_pago_id={{$trabajador->id}} data-toggle="tooltip" data-placement="top" data-title="Reiniciar deducción"><i class="fa fa-money"></i></button>
	                    <button type="button" class="btn btn-mini btn-primary pagar_retencion" data-empleado_id="{{$trabajador->usuarios->id}}" data-usuario_pago_id={{$trabajador->id}} data-toggle="tooltip" data-placement="top" data-title="Adjuntar retención"><i class="fa fa-credit-card"></i></button>
	                    <button type="button" class="btn btn-mini btn-danger reiniciar_retencion" data-empleado_id="{{$trabajador->usuarios->id}}" data-usuario_pago_id={{$trabajador->id}} data-toggle="tooltip" data-placement="top" data-title="Reiniciar retención"><i class="fa fa-credit-card"></i></button>
					</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>