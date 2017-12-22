@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style>
textarea {
    resize: none;
}
th {
    text-align: center!important;
}
/* Change the white to any color ;) */
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset !important;
}
.table td.text {
    max-width: 177px;
}
.table td.text span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    max-width: 100%;
}
td.cell{
	cursor: pointer;
}
td.cell.selected{
	background: #7db2d2d9;
}
td.cell.disabled{
	background-color: #cacaca91;
	cursor: context-menu;
}
</style>
<div class="text-center" style="margin: 20px;">
     @if(session('msg'))
    <div class="alert {{session('class')}}">
        {{session('msg')}}
    </div>
    @endif
    <h2>Resumen de hoja de asistencias</h2>
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
					<div class="text-left">
						<div class="row">
							<div class="col-md-6">
								<ul>
									<li><strong>Empresa: </strong>{{$pago->empresa->nombre}}</li>
									<li><strong>Dirección: </strong>{{$pago->empresa->direccion}}</li>
									<li><strong>Teléfono: </strong>{{$pago->empresa->telefono}}</li>
								</ul>
							</div>
							<div class="col-md-6 text-right">

							</div>
						</div>
					</div>
                    <div class="grid-body">
                        <div class="table-responsive" id="div_tabla_empresas">
                            <table class="table table-bordered table-responsive" id="nomina">
								<thead>
									<th>Num. empleado</th>
									<th>Nombre</th>
									<th>Cuenta</th>
									<th>Intervalo fechas</th>
									<th>Dias festivos</th>
									<th>Dias a pagar</th>
									<th>Empresa</th>
									<th>Subtotal</th>
								</thead>
								<tbody>
									@foreach($asistencias as $asistencia)
									<tr>
										<td>{{$asistencia->pago->usuarios->id}}</td>
										<td>{{$asistencia->pago->usuarios->nombre.' '.$asistencia->pago->usuarios->apellido}}</td>
										<td>{{$asistencia->pago->usuarios->num_cuenta}}</td>
										<td>{{date('d/M/Y', strtotime($asistencia->pago->pago->fecha_inicio))}} - {{date('d/M/Y', strtotime($asistencia->pago->pago->fecha_fin))}}</td>
										<td>{{$asistencia->festivo}}</td>
										<td>{{$asistencia->total}}</td>
										<td>{{$pago->empresa->nombre}}</td>
										<td>${{number_format($asistencia->pago->pago->servicio->sueldo_diario_guardia*$asistencia->total,2)}}</td>
									</tr>
									@endforeach
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{url('nominas')}}" class="btn btn-default">Regresar</a>
            <button id="exportar" class="btn btn-success">Exportar a Excel</button>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/tabs_accordian.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script type="text/javascript">
	$('body').delegate('#exportar','click', function() {
		window.location.href = "{{url('pagar-nomina/exportar-excel')}}/{{$pago_id}}";
	});
</script>

@endsection