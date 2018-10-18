@extends('admin.main')

@section('content')
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
ul{
	list-style: none;
	padding: 0;
}
img#company-logo{
	width: 30%;
}
</style>
<div class="text-center" style="margin: 20px;">
	@include('pagos.modal')
    @if(session('msg'))
    <div class="alert {{session('class')}}">
        {{session('msg')}}
    </div>
    @endif
    <h2>Detalle de asistencias</h2>
    <div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-info alert-dismissible text-left" role="alert">
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
		        <strong>Nomenclaturas: </strong><br>
		        A = Día festivo (No se considera para ser pagado pero puede ser añadido el día en el excel master.) <br>
		        C = Turno diurno (Se considera para ser pagado) <br>
		        D = Día de descanso (Se considera para ser pagado) <br>
		        F = Falta (No se considera para ser pagado) <br>
		        I = Incapacidad (No se considera para ser pagado) <br>
		        N = Turno nocturno (Se considera para ser pagado) <br>
		        P = Pagado (No se considera para ser pagado) <br>
		        V = Vacaciones (Se considera para ser pagado) <br>
		        X = Asistencia (Se considera para ser pagado) <br>
		        - = Sin valor (No se considera en cuenta para ser pagado) <br>
		    </div>
		</div>
	</div>
    <div class="row-fluid">
        <div class="span12" id="contenedor-detalles">
            <div class="grid simple ">
                <div class="grid-title">
					<div class="text-left">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6">
								<ul>
									<h2><li><strong>{{$pago->empresa->nombre}}</strong></li></h2>
									<h3><li><strong>{{$pago->empresa->oficina_cargo}}</strong></li></h3>
									<li>Dirección: {{$pago->empresa->direccion}}</li>
									<li>Contacto: {{$pago->empresa->contacto}}</li>
									<li>Teléfono: {{$pago->empresa->telefono}}</li>
									<li>Marcación corta: <strong>{{$pago->empresa->marcacion_corta}}</strong></li>
									<li>Servicio: {{$pago->servicio->servicio}}</li>
									<li>Número de empleados: {{$pago->num_empleados}}</li>
									<li>Horario: {{$pago->servicio->horario}}</li>
									<li>Sueldo: <strong>${{$pago->servicio->sueldo}}</strong></li>
								</ul>
							</div>
							<div class="col-md-6 visible-lg visible-md hidden-sm hidden-xs text-right" style="float: right;">
								<img src="{{asset('img/company_logo.png')}}" class="" id="company-logo" alt="company-logo">
							</div>
						</div>
					</div>
                    <div class="grid-body">
                        <div class="table-responsive" id="div_tabla_asistencias">
                            @include('pagos.tabla_asistencias')
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{$pago->status != 0 ? url('nominas') : url('historial')}}" class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
            <button id="agregar_empleado" class="btn btn-success {{$pago->status == 0 ? 'hide' : ''}}"><i class="fa fa-plus" aria-hidden="true"></i> Agregar empleado</button>
            <button id="guardar" class="btn btn-primary {{$pago->status != 0 ? '' : 'hide'}}">
            	<i class="fa fa-floppy-o" aria-hidden="true"></i>
                <i class="fa fa-spinner fa-spin" style="display: none;"></i>
            	Guardar
            </button>
            <button id="borrar_empleados" class="btn btn-danger {{$pago->status == 0 ? 'hide' : ''}}" disabled><i class="fa fa-trash" aria-hidden="true"></i> Eliminar empleados</button>
			<a href="{{url('pagar-nomina/'.$pago->id)}}" class="btn btn-success {{$pago->status != 2 ? 'hide' : ''}}" id="btn-pagar"><i class="fa fa-money" aria-hidden="true"></i> Pagar</a>
			<a href="{{url('nominas/pdf/'.$pago->id)}}" target="_blank" class="btn btn-info" id="btn-pagar"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/tabs_accordian.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/pagosAjax.js') }}"></script>
<script src="{{ asset('js/validacionesPagos.js') }}"></script>
<script type="text/javascript">
	/*$('table').each('td',function(){
		console.log($(this))
		var col = $(this).prevAll().length;
		if (  !$(this).parents('table').find('th').eq(col).hasClass('edit') ){
			$(this).css('background','black')
		}
	})*/

	/*Empiezan los métodos para pagar la retención*/
    $('body').delegate('.pagar_deduccion','click', function() {
		empleado_id = $(this).data('empleado_id');
		usuario_pago_id = $(this).data('usuario_pago_id');

		config = {
            'route'           : "{{url('deducciones/mostrar-detalles')}}",
            'empleado_id'     : empleado_id,
            'usuario_pago_id' : usuario_pago_id,
            'callback'        : 'mostrar_deducciones_empleado',
        }
        loadingMessage('Cargando deducciones del empleado...');
        ajaxSimple(config);
	});

	//Checa qué deducciones están marcadas para pagar
    $('body').delegate('#adjuntar-deduccion', 'click', function() {
        var detalles_ids = [];
        $("input.checkDeduccion").each(function() {
            if ($(this).is(':checked')) {
                detalles_ids.push($(this).parent().parent().siblings("td:nth-child(1)").text());
            }
        });
        console.log(detalles_ids)
        if (detalles_ids.length > 0) {

			var usuario_pago_id = $('input[name="usuario_pago_id"').val();

			config = {
	            'route'           : "{{url('deducciones/pagar')}}",
	            'ids'             : detalles_ids,
	            'usuario_pago_id' : usuario_pago_id,
	            'redirect_to'     : window.location.href+'/1',
	            'refresh'         : 'table',
	            'table_id'        : 'nomina'
	        }
	        loadingMessage('Cargando deducciones del empleado...');
	        ajaxSimple(config);
        } else {
			swal('Error', 'Necesita seleccionar al menos una retención a pagar', 'error');
        }


        //$('.delete-rows').attr('disabled', detalles_ids.length > 0 ? false : true);
    });

	function mostrar_deducciones_empleado(data, config) {
		var deducs = data.deducciones;
		$('div.deduccion-detalles tbody').children().remove();
		//console.log(data);
		if ( deducs.length > 0 ) {
			//Deducción detalle ID
            //ID deducción
            //Total a pagar
            //Cantidad
            //Acción
            for (var key in deducs) {
                if (deducs.hasOwnProperty(key)) {
                	detalles = deducs[key].detalles;
                	for (var key_d in detalles) {
                		if (detalles.hasOwnProperty(key_d)) {
                			if (detalles[key_d].status == 0) {
	                			$('div.deduccion-detalles tbody').append(
									"<tr>"+
										"<td class='hide'>"+detalles[key_d].id+"</td>"+
										"<td>"+deducs[key].id+"</td>"+
										"<td>"+deducs[key].total+"</td>"+
										"<td>"+detalles[key_d].cantidad+"</td>"+
										"<td class='small-cell v-align-middle'>"+
					                        "<div class='checkbox check-success'>"+
					                        	"<input id='checkbox_d"+detalles[key_d].id+"' type='checkbox' class='checkDeduccion' value='1'>"+
					                        	"<label for='checkbox_d"+detalles[key_d].id+"'></label>"+
					                        "</div>"+
										"</td>"+
									"</tr>"
								);
	                		}
                		}//Detalle for
                	}
                }
            }//Deduccion for
            //$('.').show();
		} else {
            $('div.deduccion-detalles tbody').append("<tr><td colspan='5'>No hay retenciones pendientes por cobrar</td></tr>");
		}

		$('#form-pagar-deduccion input[name="usuario_pago_id"').val(config.usuario_pago_id);

		$('#modal-pagar-deduccion').modal()
	}

	/*Se agregan las clases necesarias para poder editar las celdas de la tabla y tomar asistencias*/
	$(function(){
		$(".select2").select2();

		$('table#nomina tbody').find('td.cell').each (function() {
			var col = $(this).prevAll().length;
			if (  !$(this).parents('table').find('th').eq(col).hasClass('edit') ){
				$(this).addClass('disabled')
			}
		});

		$('body').delegate('td','click', function() {
			var col = $(this).prevAll().length;
			if ( $(this).parents('table').find('th').eq(col).hasClass('edit') ){
				if ( !$(this).hasClass('selected') ){
					$(this).addClass('selected')
				} else {
					$(this).removeClass('selected')
				}
			}
		})
		
		/*Se valida que las teclas presionadas marquen una letra en las celdas seleccionadas*/
		$(document).keypress(function(e){
			if (
				e.which == 97 || e.which == 65 || /*A*/
				e.which == 99 || e.which == 67 || /*C*/
				e.which == 68 || e.which == 100 || /*D*/
				e.which == 102 || e.which == 70 || /*F*/
				e.which == 105 || e.which == 73 || /*I*/
				e.which == 110 || e.which == 78 || /*N*/
				e.which == 112 || e.which == 80 || /*P*/
				e.which == 118 || e.which == 86 || /*V*/
				e.which == 88 || e.which == 120 || /*X*/
				e.which == 45 /*-*/) {
					$(document).find('.selected').text(e.key.toUpperCase()).removeClass('edit, selected').addClass('done')
			}
		});
	});

	/*Elimina los empleados de la lista de asistencias*/
	$('body').delegate('#borrar_empleados','click', function() {
	    var checking = [];
	    $("input.checkDelete").each(function() {
	        if($(this).is(':checked')) {
	            checking.push($(this).parent().parent().siblings("td:nth-child(4)").data('pago'));
	        }
	    });
	    if (checking.length > 0) {
	    	console.log(checking);
	        swal({
	            title: "¿Realmente desea eliminar <span style='color:#F8BB86'>" + checking.length + "</span> empleados de la lista de asistencia?",
	            text: "¡Cuidado, ésta acción no podrá deshacerse y se perderán los registros de asistencia!",
	            html: true,
	            type: "warning",
	            showCancelButton: true,
	            cancelButtonText: "Cancelar",
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Si, continuar",
	            showLoaderOnConfirm: true,
	            allowEscapeKey: true,
	            allowOutsideClick: true,
	            closeOnConfirm: false
	        },
	        function() {
	            eliminarEmpleadosLista(checking);
	        });
	    }
	});

	/*Se agrega un nuevo empleado a la lista de asistencias*/
	$('#agregar-empleado-lista').on('click', function() {
		button = $(this);
    	workers = validarSelect($('select#trabajadores_id'));
    	if (!workers) {
			swal('Error', 'Porfavor, seleccione al menos un empleado para continuar', 'error')
    	} else {
    		button.children('i').show();
            button.attr('disabled', true);
    		agregarEmpleado(button);
    	}
	});

	/*Abre el modal para elegir los empleados a agregar*/
	$('#agregar_empleado').on('click', function() {
        $('select#trabajadores_id').select2("val", "");
		$('#modal-agregar-empleado').modal();
	});

	/*Habilita el botón para dar bajas múltiples*/
	$('body').delegate('.checkDelete','click', function() {
		var checking = [];
	    $("input.checkDelete").each(function() {
	        if($(this).is(':checked')) {
	            checking.push($(this).parent().parent().parent().attr('id'));
	        }
	    });
	    if (checking.length > 0) {
	    	$('#borrar_empleados').attr('disabled', false);
	    } else {
	    	$('#borrar_empleados').attr('disabled', true);
	    }
	});

	/*Arma el json con los datos de las asistencias de los empleados*/
	$('#guardar').on('click', function(){
		var button = $(this);
		var empty = 0;

		$('table#nomina tbody').find('td.cell').each (function() {
			var col = $(this).prevAll().length;
			if ( $(this).parents('table').find('th').eq(col).hasClass('edit') ){
				if ( $.inArray($(this).text().trim(), ['A', 'C', 'D', 'F', 'I', 'N', 'P', 'V', 'X', '-']) < 0 ) {
					empty++;
				}
			}
		});

		if( empty > 0 ){
			swal('Error', 'Necesita llenar los campos disponibles', 'error')
			return false;
		}

		var collection = [];
		$('table#nomina tbody').find('tr').each (function() {
			var obj = new Object();
			obj.days = [];
			$(this).find('td').each(function(){
				var ele = $(this);
				var array = [];
				if ( $(this).data('user') ){
					obj.user_id = $(this).data('user');
					obj.pago_id = $(this).data('pago');
					obj.real_id_pago = $(this).data('realid');
				} else if( $(this).data('notes') ){
					obj.notas = $(this).find('input').val()
				}else if( $(this).hasClass('cell') ){
					if ( $.inArray(ele.text(), ['A', 'C', 'D', 'F', 'I', 'N', 'P', 'V', 'X', '-']) >= 0 ){
						var txt = ele.text();
					} else {
						var txt = '';
					}
					array = {
						'dia' : ele.data('dia'),
						'status' : txt
					}
					obj.days.push(
						array
					)
				}
			})
			collection.push(obj);
		});

		var json = JSON.stringify(collection);

		button.children('i.fa-spin').show();
		button.children('i.fa-floppy-o').hide();
        button.attr('disabled', true);

		guardarAsistencias(json,button);
	})
</script>
@endsection