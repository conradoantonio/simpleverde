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
                                    <option value="{{$trabajador->id}}">{{$trabajador->num_empleado}} - {{$trabajador->nombre}}</option>
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