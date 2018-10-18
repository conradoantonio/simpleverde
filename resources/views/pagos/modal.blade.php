<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo-agregar-empleado" id="modal-agregar-empleado">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulo-agregar-empleado">Agregar empleado</h4>
            </div>
            <form id="form-agregar-empleado" onsubmit="return false" action="{{ url('pagos/agregar_empleado') }}" enctype="multipart/form-data" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 hide">
                            <div class="form-group">
                                <label for="pago_id">Pago ID</label>
                                <input type="text" class="" id="pago_id" name="pago_id" value="{{$pago_id}}">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="trabajadores_id">Trabajadores</label>
                            <select name="trabajadores[]" id="trabajadores_id" class="select2" multiple="multiple" style="width: 100%;">
                                <option value="0" disabled>Seleccionar trabajadores</option>
                                @foreach($trabajadores as $trabajador)
                                    <option value="{{$trabajador->id}}">{{$trabajador->num_empleado}} - {{$trabajador->nombre.' '.$trabajador->apellido_paterno.' '.$trabajador->apellido_materno}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="agregar-empleado-lista">
                        Agregar
                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo-pagar-deduccion" id="modal-pagar-deduccion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulo-pagar-deduccion">Deducciones a pagar</h4>
            </div>
            <form id="form-pagar-deduccion" onsubmit="return false" action="{{ url('deducciones/pagar') }}" enctype="multipart/form-data" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 hide">
                            <div class="form-group">
                                <label for="usuario_pago_id">Usuario pago ID</label>
                                <input type="text" class="" name="usuario_pago_id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row deduccion-detalles">
                        <table class="table" id="empleado_deducciones">
                            <thead>
                                <tr>
                                    <td class="hide">Deducción detalle ID</td>
                                    <td>ID deducción</td>
                                    <td>Total a pagar</td>
                                    <td>Cantidad</td>
                                    <td>Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        {{-- Aquí aparecerán dinámicamente las deducciones del empleado --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="adjuntar-deduccion">Adjuntar deducción</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->