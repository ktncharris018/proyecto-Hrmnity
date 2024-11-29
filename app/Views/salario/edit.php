<!DOCTYPE html>
<html lang="es">
<?php echo view('Layouts/head'); ?>
<!--
  HOW TO USE: 
  data-theme: default (default), dark, light, colored
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-layout: default (default), compact
-->

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        <?php echo view('Layouts/sidebar'); ?>
        <div class="main">
            <?php echo view('Layouts/navbar'); ?>
            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Agregar Salario del Empleado</h1>

                    <div class="">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="account" role="tabpanel">

                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                <?php elseif (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('success') ?>
                                    </div>
                                <?php endif; ?>

                                <div class="card-header">
                                    <h5 class="card-title mb-0">Public Info</h5>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" class="ajax-form" action="<?= base_url('public/salario/update') ?>" enctype="multipart/form-data">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="id" value="<?= $salario['id_salario']; ?>">
                                            <div class="row">
                                                
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputEncargado">Empleado Encargado</label>
                                                        <select name="empleado_id" id="inputEncargado"
                                                            class="form-control">
                                                            <option selected>Elegir...</option>
                                                            <?php 
                                                                #var_dump($departamentos);
                                                                foreach ($empleados as $empleado):
                                                                
                                                                $selected = ($empleado['id_empleado'] === $salario['empleado_id']) ? 'selected' : '';
                                                                echo "<option value='{$empleado['id_empleado']}' $selected>{$empleado['nombre']}</option>";
    
                                                                endforeach;      
                                                            
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputsalario">Salario Base</label>
                                                        <input name="salario_base" type="text" class="form-control formatear-numero"
                                                            id="inputsalario" placeholder="Ingrese la cifra sin comas y puntos (. ,)" value="<?= $salario['salario_base']?> ">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="inputAuxtransporte">Auxilio de Transporte</label>
                                                        <input name="aux_transporte" type="text" class="form-control formatear-numero"
                                                            id="inputAuxtransporte" placeholder="Ingrese la cifra sin comas y puntos (. ,)"
                                                            title="por favor no escriba : coma y puntos" value="<?= $salario['aux_transporte']?> " >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputbonificacion">Bonificacion</label>
                                                        <input name="bonificacion" type="text" class="form-control formatear-numero"
                                                            id="inputbonificacion" placeholder="numero de telefono"
                                                            title="por favor no escriba : coma y puntos" value="<?= $salario['bonificacion']?> ">
                                                    </div>
                                                    <hr>
                                                    <label for="form-label">Deducciones: </label>
                                                    <br>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">

                                                            <div class="form-check form-switch">
                                                                <?php
                                                                    $checked = ($salario['deduccion_salud'] > 0) ? 'checked' : '';
                                                                    echo "<input class='form-check-input' name='deduccion_salud' type='checkbox' id='flexSwitchCheckDefault' $checked>"
                                                                ?>
                                                                <label class="form-check-label" for="flexSwitchCheckDefault">Aporte a la salud</label>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md-4">

                                                            <div class="form-check form-switch">
                                                                <?php
                                                                    $checked = ($salario['deduccion_pension'] > 0) ? 'checked' : '';
                                                                    echo "<input class='form-check-input' name='deduccion_pension' type='checkbox' id='flexSwitchCheckChecked' $checked>"
                                                                ?>
                                                                <label class="form-check-label" for="flexSwitchCheckChecked">Aporte a pension</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <img alt="perfil del usuario" id="preview"
                                                            src="<?= config('App')->imgURL; ?>/avatars/icono-salario.png"
                                                            class="rounded-circle img-responsive mt-2" width="128"
                                                            height="128" />
                                                        <div class="mt-2">

                                                        </div>    
                                                        <input type="file" name="foto_perfil" id="file-input"
                                                            accept="image/jpeg, image/png, image/jpeg"
                                                            style="display:none">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2 d-md-flex">
                                                <button type="submit" class="btn btn-success btn-lg mb-2">guardar
                                                    cambios</button>
                                                <button type="reset"
                                                    class="btn btn-danger btn-lg mb-2">Cancelar</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="password" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Password</h5>

                                        <form>
                                            <div class="mb-3">
                                                <label class="form-label" for="inputPasswordCurrent">Current
                                                    password</label>
                                                <input type="password" class="form-control" id="inputPasswordCurrent">
                                                <small><a href="#">Forgot your password?</a></small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="inputPasswordNew">New
                                                    password</label>
                                                <input type="password" class="form-control" id="inputPasswordNew">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="inputPasswordNew2">Verify
                                                    password</label>
                                                <input type="password" class="form-control" id="inputPasswordNew2">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <?php echo view('Layouts/footer'); ?>
        </div>
    </div>

    <?php echo view('Layouts/script-js'); ?>

    <script>
        $(document).ready(function() {
            // Función para formatear el número
            function formatearNumero(valor) {
                // Quitar caracteres no numéricos, excepto el punto y la coma
                valor = valor.replace(/[^0-9]/g, ''); // Solo mantener dígitos
                // Formatear la parte entera con puntos
                return valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Evento para formatear el número al escribir en inputs con la clase "formatear-numero"
            $(document).on('input', '.formatear-numero', function() {
                const valorFormateado = formatearNumero($(this).val());
                $(this).val(valorFormateado);
            });

            // Limpiar los inputs antes de enviar el formulario
            $('form').on('submit', function() {
                $('.formatear-numero').each(function() {
                    // Eliminar puntos y cambiar la coma por un punto
                    const valorLimpio = $(this).val().replace(/\./g, '');
                    $(this).val(valorLimpio); // Actualiza el input para el envío
                });
            });
        });
    </script>



    <script>
        // const myInput = document.querySelector("#inputFechat");
        // const fp = flatpickr(myInput, {});          
		document.addEventListener("DOMContentLoaded", function() {
			// Choices.js
			// Flatpickr
			flatpickr(".flatpickr-basic");
			flatpickr(".flatpickr-datetime", {
				enableTime: true,
				dateFormat: "Y-m-d H:i",
			});
			flatpickr(".flatpickr-human", {
				altInput: true,
				altFormat: "F j, Y",
				dateFormat: "Y-m-d",
                onReady: function(selectedDates, dateStr, instance) {
                    // Cambiar el cursor a pointer
                    instance.altInput.style.cursor = "pointer"; // Para el altInput
                    instance.input.style.cursor = "pointer"; // Para el input original
                }
			});
			flatpickr(".flatpickr-multiple", {
				mode: "multiple",
				dateFormat: "Y-m-d"
			});
			flatpickr(".flatpickr-range", {
				mode: "range",
				dateFormat: "Y-m-d"
			});
			flatpickr(".flatpickr-time", {
				enableTime: true,
				noCalendar: true,
				dateFormat: "H:i",
			});
		});
	</script>
    <script>
                // Mostrar notificaciones basadas en la sesión
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener mensajes de sesión desde PHP (esto debería ser configurado según tu backend)
            const successMessage = '<?= session()->getFlashdata('success') ?>';
            const errorMessage = '<?= session()->getFlashdata('error')?>';

            if (successMessage) {
                showNotification('success', successMessage);
            }
            if (errorMessage) {
                showNotification('error', errorMessage);
            }
        });

    </script>
</body>

</html>