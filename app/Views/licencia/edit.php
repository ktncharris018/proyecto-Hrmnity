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

                    <h1 class="h3 mb-3">Agregar Licencias</h1>

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
                                        <form method="post" class="ajax-form" action="<?= base_url('public/licencia/update') ?>" enctype="multipart/form-data">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="estado_anterior" value="<?= $licencia['estado'] ?>" >
                                                <input type="hidden" name="id" value="<?= $licencia['id_licencia']; ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputcandidato">Nombre Empleado</label>
                                                        <select name="empleado_id" id="inputcandidato" class="form-control">
                                                            <option selected>Elegir...</option>
                                                            <?php 
                                                             foreach ($empleados as $empleado):
                                                                $selected = ($empleado['id_empleado'] === $licencia['empleado_id']) ? 'selected' : '';
                                                                echo "<option value='{$empleado['id_empleado']}' $selected>{$empleado['nombre']}</option>";
                                                            endforeach;      
                                                            
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputTipo">Tipo Licencia</label>
                                                            <select name="tipo" id="inputTipo" class="form-control">
                                                                <option selected>Elegir...</option>
                                                                <?php 
                                                                    foreach ($valoresLicencias as  $valor) {
                                                                        $selected = ($valor === $licencia['tipo']) ? 'selected' : '';
                                                                        echo "<option value='{$valor}' $selected>{$valor}</option>";

                                                                    }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputEstado">estado de la Licencia</label>
                                                            <select name="estado" id="inputEstado" class="form-control">
                                                                <option selected>Elegir...</option>
                                                               <?php  if($licencia['estado']==='aproabada'){?> 
                                                                    <option value="aprobada" selected>Aprobada</option>
                                                                    <option value="rechazada">Rechazada</option>
                                                               <?php }else if($licencia['estado']==='pendiente'){?> 
                                                                    <option value="pendiente" selected>Pendiente</option>
                                                                    <option value="aprobada">Aprobada</option>
                                                                    <option value="rechazada">Rechazada</option>
                                                                <?php }else{ ?>
                                                                    <option value="aprobada">Aprobada</option>
                                                                    <option value="rechazada" selected>Rechazada</option>
                                                                <?php }?>


                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputFechaInicio">Fecha de Inicio</label>
                                                        <input name="fecha_inicio" type="date"  class="form-control flatpickr-basic"
                                                            id="inputFechaInicio" placeholder="Seleccione la fecha" value="<?= $licencia['fecha_inicio'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputFechaFinal">Fecha de Final</label>
                                                        <input name="fecha_final" type="date"  class="form-control flatpickr-basic"
                                                            id="inputFechaFinal" placeholder="Seleccione la fecha" value="<?= $licencia['fecha_final'] ?>">
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

    <!-- <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        setTimeout(function() {
            if (localStorage.getItem('popState') !== 'shown') {
                window.notyf.open({
                    type: "success",
                    message: "Get access to all 500+ components and 45+ pages with AdminKit PRO. <u><a class=\"text-white\" href=\"https://adminkit.io/pricing\" target=\"_blank\">More info</a></u> 🚀",
                    duration: 10000,
                    ripple: true,
                    dismissible: false,
                    position: {
                        x: "left",
                        y: "bottom"
                    }
                });

                localStorage.setItem('popState', 'shown');
            }
        }, 15000);
    });
    </script> -->

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