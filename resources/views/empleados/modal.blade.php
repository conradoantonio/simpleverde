<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_tipo_servicio" id="md-deducciones">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulo_tipo_servicio">Nueva deducción</h4>
            </div>
            <form enctype="multipart/form-data" action="{{url('deducciones/guardar')}}" method="POST" onsubmit="return false;" autocomplete="off" id="form-deducciones" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="div_tabla_empleados">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 hide">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control not-empty" name="empleado_id" data-msg="ID empleado">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="total">Monto</label>
                                <input type="text" class="form-control not-empty" name="total" data-msg="Monto">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="num_pagos">Número de pagos</label>
                                <input type="text" class="form-control not-empty" name="num_pagos" data-msg="Número de pagos">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="comentarios">Comentarios</label>
                                <textarea class="form-control not-empty" name="comentarios" data-msg="Comentarios"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save" id="guardar-servicio">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_tipo_servicio" id="md-retenciones">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulo_tipo_servicio">Nueva retención</h4>
            </div>
            <form enctype="multipart/form-data" action="{{url('retenciones/guardar')}}" method="POST" onsubmit="return false;" autocomplete="off" id="form-retenciones" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="div_tabla_empleados">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 hide">
                            <div class="form-group">
                                <label for="empleado_id">ID</label>
                                <input type="text" class="form-control not-empty" name="empleado_id" data-msg="ID empleado">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="empresa_id">Empresa (Lugar)</label>
                            <select name="empresa_id" class="select2 not-empty" style="width: 100%;" data-msg="Empresa (Lugar)">
                                <option value="0">Seleccionar empresa</option>
                                @if(isset($empresas))
                                    @foreach($empresas as $empresa)
                                        <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_inicio">Fecha inicio</label>
                            <input type="text" class="form-control not-empty" name="fecha_inicio" data-msg="Fecha inicio">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_fin">Fecha fin</label>
                            <input type="text" class="form-control not-empty" name="fecha_fin" data-msg="Fecha fin">
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="importe">Importe</label>
                                <input type="text" class="form-control not-empty" name="importe" data-msg="Importe">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="num_dias">Número de días</label>
                                <input type="text" class="form-control not-empty" name="num_dias" data-msg="Número de días">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="comentarios">Comentarios</label>
                                <textarea class="form-control not-empty" name="comentarios" data-msg="Comentarios"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save" id="guardar-servicio">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="h4-ded-det" id="md-detalle-deducciones">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="h4-ded-det">Detalles</h4>   
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table" id="tb-detalle-deduccion">
                            <thead>
                                <tr>
                                    <td class="hide">ID</td>
                                    <td>Cantidad</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-primary save" id="">Guardar</button> --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->