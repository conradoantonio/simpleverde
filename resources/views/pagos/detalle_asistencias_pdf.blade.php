<!DOCTYPE html>
<html>
<head>
	<title>PDF de asistencias</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<style>
	.color{
		background-color: gray;
		font-weight: bold;
	}
	.none{
		background-color:none;
	}
	</style>
</head>

<body>
	 <div class="row">
		<div class="">
			<h3><strong>{{$pago->empresa->nombre}}</strong></h3>
			<h4><strong>{{$pago->empresa->oficina_cargo}}</strong></h4>
			<h6>Dirección: {{$pago->empresa->direccion}}</h6>
			<h6>Contacto: {{$pago->empresa->contacto}}</h6>
			<h6>Teléfono: {{$pago->empresa->telefono}}</h6>
			<h6>Marcación corta: <strong>{{$pago->empresa->marcacion_corta}}</strong></h6>
			<h6>Servicio: {{$pago->servicio->servicio}}</h6>
			<h6>Número de empleados: {{$pago->num_empleados}}</h6>
			<h6>Horario: {{$pago->servicio->horario}}</h6>
			<h6>Sueldo: <strong>${{$pago->servicio->sueldo}}</strong></h6>
		</div>
		<div class="" style="float: right;">
			<img src="{{asset('img/company_logo.png')}}" alt="company-logo">
		</div>
	</div>
	<br>
	<table id="" class="table">
		<thead class="thead-light">
			<tr>
				<th style="width: 10px;">ID</th>
				<th style="width: 10px;">No. Empleado</th>
				<th style="width: 10px;">Nombre</th>
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
			</tr>
		</thead>
		<tbody>
			@foreach( $pago->PagoUsuarios as $trabajador )
				<tr>
					<td>{{$trabajador->usuarios->id}}</td>
					<td>{{$trabajador->usuarios->num_empleado}}</td>
					<td data-user={{$trabajador->usuarios->id}} data-realid={{$pago->id}} data-pago={{$trabajador->id}}>{{$trabajador->usuarios->nombre}} {{$trabajador->usuarios->apellido_paterno}} {{$trabajador->usuarios->apellido_materno}}</td>
					@if( count($asistencias) == 0 )
	    				@foreach( $dias as $day )
							<td class="cell" data-dia="{{$day['num']}}"></td>
						@endforeach
					@else
						@foreach( $asistencias as $asistencia )
                            @if( $asistencia->pago->id == $trabajador->id)
								<td class="cell" data-dia="{{$asistencia->dia}}">{{$asistencia->status}}</td>
							@endif
						@endforeach
					@endif
					<!--<td data-notes="1">{{$trabajador->notas?$trabajador->notas:''}}</td>-->
				</tr>
			@endforeach
		</tbody>
	</table>
	<br>
	<table id="" class="table">
		<thead class="thead-light">
			<tr>
				<th style="width: 10px;">ID</th>
				<th>Notas</th>
			</tr>
		</thead>
		<tbody>
			@foreach( $pago->PagoUsuarios as $trabajador )
				<tr>
					<td>{{$trabajador->usuarios->id}}</td>
					<td data-notes="1">{{$trabajador->notas?$trabajador->notas:''}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>

