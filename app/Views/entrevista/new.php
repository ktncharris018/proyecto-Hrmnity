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

                    <h1 class="h3 mb-3">Agregar Entrevista</h1>

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
                                        <form method="post" class="ajax-form" action="<?= base_url('public/entrevista') ?>"
                                            enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputcandidato">Candidato Preseleccionado</label>
                                                            <select name="candidato_id" id="inputcandidato"
                                                                class="form-control">
                                                                <option selected>Elegir...</option>
                                                                <?php 
                                                                    #var_dump($candidatos);
                                                                 foreach ($candidatos as $candidato):
                                                                   if ($candidato['estado']==='preseleccionado') {
                                                                       # code...
                                                                       echo "<option value='{$candidato['id_candidato']}''>{$candidato['nombre']}</option>";
                                                                   }


                                                                 endforeach;      
                                                                
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputEstado">estado de la entrevista</label>
                                                            <select name="estado" id="inputEstado" class="form-control" disabled>
                                                                <option selected>Elegir...</option>
                                                                <option value="contratado">Contratado</option>
                                                                <option selected value="seleccionado">Seleccionado</option>
                                                                <option value="rechazado">Rechazado</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Observacion</label>
                                                        <textarea class="form-control" name="observacion" placeholder="Escriba una observacion de la entrevista" rows="1"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputFecha">Fecha de la entrevista</label>
                                                        <input name="fecha" type="date"  class="form-control flatpickr-basic"
                                                            id="inputFecha" placeholder="Seleccione la fecha">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputfile">Soporte</label>
                                                        <input name="soporte" type="file" accept="application/pdf" class="form-control"
                                                            id="inputfile" placeholder="nombre de su jefe inmediato">
                                                    </div>


                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <img alt="perfil del usuario" id="preview"
                                                            src="<?= config('App')->imgURL; ?>/avatars/icono-entrevista.png"
                                                            class="rounded-circle img-responsive mt-2" width="128"
                                                            height="128" />
                                                        <div class="mt-2">

                                                            <small>NOTA: la entrada "soporte" Acepta solo documento .pdf de max 10MB. resolucion
                                                                recomendada: documento de buena calidad.</small>
                                                                <br>
                                                            <small>IMPORTANTE: al cambiar el estado a "contratado" el candidato se convertira en empleado de la empresa</small>    
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