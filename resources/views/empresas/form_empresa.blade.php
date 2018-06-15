<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_form_empresa" id="formulario_empresa">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulo_form_empresa">Nueva empresa</h4>
            </div>
            <form id="form_empresa" lsd="form-data" action="" enctype="multipart/form-data" method="POST" onsubmit="return false" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="table" data-redirect="0" data-table_id="example3" data-container_id="table_container">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 hidden">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" id="id" name="id">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nombre" class="required">Nombre</label>
                                <input type="text" class="form-control not-empty" id="nombre" name="nombre" placeholder="Nombre" data-msg="Nombre">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="oficina_cargo">Oficina a cargo</label>
                                <input type="text" class="form-control" id="oficina_cargo" name="oficina_cargo" placeholder="Oficina a cargo" data-msg="Oficina a cargo">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion" placeholder="Dirección" data-msg="Dirección"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control" id="contacto" name="contacto" placeholder="Contacto" data-msg="Contacto">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" data-msg="Teléfono">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="marcacion_corta">Marcación corta</label>
                                <input type="text" class="form-control" id="marcacion_corta" name="marcacion_corta" placeholder="Marcación corta" data-msg="Marcación corta">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="contrato">Contrato</label>
                                <input type="text" class="form-control" id="contrato" name="contrato" placeholder="Contrato" data-msg="Contrato">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="numero_elementos">Número de elementos</label>
                                <input type="text" class="form-control" id="numero_elementos" name="numero_elementos" placeholder="Número de elementos" data-msg="Número de elementos">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="rfc">RFC</label>
                                <input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" data-msg="RFC">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="tipo_pago">Tipo de pago</label>
                                <input type="text" class="form-control tipo_pago" id="tipo_pago" name="tipo_pago" placeholder="Tipo de pago" data-msg="Tipo de pago">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de inicio</label>
                                <input type="text" class="form-control date-picker" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha de inicio" data-msg="Fecha de inicio">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="fecha_termino">Fecha de término</label>
                                <input type="text" class="form-control date-picker" id="fecha_termino" name="fecha_termino" placeholder="Fecha de término" data-msg="Fécha de término">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea class="form-control" rows="3" id="observaciones" name="observaciones" placeholder="Observaciones" data-msg="Observaciones"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save" id="guardar_empresas">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->