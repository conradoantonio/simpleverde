@extends('admin.main')

@section('content')
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

}.select-error{
	border-color: #A94442;
	border-style: solid;
	border-width: 1px;
}
</style>
<div class="text-center" style="margin: 20px;">
    <h2>Alta lista de asistencia</h2>
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <div class="grid-body">
                        <form action="{{url('guardarPago')}}" method="post">
                        	{!! csrf_field() !!}
                        	<div class="row">
								<div class="form-group col-md-12">
									<label for="empresa_id">Empresa</label>
									<select name="empresa_id" id="empresa_id" class="select2" style="width: 100%;">
										<option value="0">Seleccionar empresa</option>
										@foreach($empresas as $empresa)
											<option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-12">
									<label for="servicio_id">Servicio</label>
									<select name="servicio_id" id="servicio_id" class="select2" style="width: 100%;">
										<option value="0">Seleccionar servicio</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="intervalo">Fecha inicio</label>
									<div class="input-append success date col-md-11 no-padding">
										<input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio">
										<span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label for="intervalo">Fecha fin</label>
									<div class="input-append success date col-md-11 no-padding">
										<input type="text" class="form-control" name="fecha_fin" id="fecha_fin">
										<span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label for="trabajadores_id">Trabajadores</label>
									<select name="trabajadores[]" id="trabajadores_id" class="select2" multiple="multiple" style="width: 100%;">
										<option value="0">Seleccionar trabajadores</option>
										@foreach($trabajadores as $trabajador)
											<option value="{{$trabajador->id}}">{{$trabajador->num_empleado}} - {{$trabajador->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="botonera col-md-12">
								<a href="{{url('nominas')}}" class="btn btn-default">Regresar</a>
								<button type="submit" id="guardar_pago" class="btn btn-primary">Generar</button>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pagosAjax.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/validacionesPagos.js') }}" type="text/javascript"></script>
<script>
	$(function(){
		$(".select2").select2();

		$( "#fecha_inicio" ).datepicker({
			autoclose: true,
			todayHighlight: true,
			format: "yyyy-mm-dd",
		}).on( "changeDate", function(e) {
			$( "#fecha_fin" ).setStartDate = e.date;
		});

		$( "#fecha_fin" ).datepicker({
			autoclose: true,
			todayHighlight: true,
			format: "yyyy-mm-dd",
		}).on( "changeDate", function(e) {
			$( "#fecha_inicio" ).setEndDate = e.date;
		});
	})

	$( "select#empresa_id" ).change(function() {
		elem_to_block = $('select#servicio_id').parent('div').children('div.select2-container');
        blockUI(elem_to_block);
		cargarServicios($(this).val(), elem_to_block);
	});
</script>
@endsection