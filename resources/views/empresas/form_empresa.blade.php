<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_form_empresa" id="formulario_empresa">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulo_form_empresa">Nueva empresa</h4>
            </div>
            <form id="form_empresa" action="" enctype="multipart/form-data" method="POST" onsubmit="return false" autocomplete="off">
                <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}" base-url="<?php echo url();?>">
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
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="oficina_cargo">Oficina a cargo</label>
                                <input type="text" class="form-control" id="oficina_cargo" name="oficina_cargo" placeholder="Oficina a cargo">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion" placeholder="Dirección"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control" id="contacto" name="contacto" placeholder="Contacto">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="marcacion_corta">Marcación corta</label>
                                <input type="text" class="form-control" id="marcacion_corta" name="marcacion_corta" placeholder="Marcación corta">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="guardar_empresa">
                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                        Guardar
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->