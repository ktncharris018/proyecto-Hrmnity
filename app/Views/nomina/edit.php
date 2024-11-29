

<div class="modal fade" id="modalEditNomina<?php if(isset($id_nomina)){ echo $id_nomina; } ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Nomina</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('public/nomina/update') ?>" method="post" class="ajax-form">
                <div class="modal-body m-3">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="<?php if(isset($id_nomina)){ echo $id_nomina; } ?>">
                    <input type="hidden" name="idSalario" value="<?php if(isset($salario_id)){ echo $salario_id; } ?>">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label" for="inputHextras">Valor Horas Extras</label>
                            <input name="valor_horas" type="text" class="form-control formatear-numero"
                                id="inputHextras" placeholder="Ingrese la cifra sin comas y puntos (. ,)" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputCantidadHextras">Cantidad Horas Extras</label>
                            <input type="number" class="form-control" id="inputCantidadHextras" name="cantidad_horas_extras" min="0" step="1" required
                                title="por favor no escriba : coma y puntos" placeholder="ingrese una cantidad">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputCantidaAusencia">Cantidad de dias de Ausencia</label>
                            <input type="number" class="form-control" id="inputCantidaAusencia" name="cantidad_ausencia" min="0" step="1" required 
                                title="por favor no escriba : coma y puntos" placeholder="ingrese una cantidad">
                        </div>

                        
                    </div>

                
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger">Resetear</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

