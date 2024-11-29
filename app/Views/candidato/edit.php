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

                    <h1 class="h3 mb-3">Editar Candidato</h1>

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
                                        <form method="post" class="ajax-form" action="<?= base_url('public/candidato/update') ?>"
                                            enctype="multipart/form-data">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="id" value="<?= $candidatos['id_candidato']; ?>">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputUsername">Nombre del candidato</label>
                                                        <input name="nombre" type="text" class="form-control" value="<?= $candidatos['nombre']?>"
                                                            id="inputUsername" placeholder="Username">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="inputidentificacion">Identificacion candidato</label>
                                                        <input name="identificacion" type="text" class="form-control"
                                                            id="inputidentificacion" placeholder="identificcion"
                                                            maxlength="10" pattern="\d{1,10}" value="<?= $candidatos['identificacion']?>"
                                                            title="El número debe ser numérico y tener entre 1 y 10 dígitos.">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputcontacto">Numero de
                                                            contacto</label>
                                                        <input name="contacto" type="text" class="form-control"
                                                            id="inputcontacto" placeholder="numero de telefono"
                                                            maxlength="10" pattern="\d{1,10}" value="<?= $candidatos['contacto']?>"
                                                            title="El número debe ser numérico y tener entre 1 y 10 dígitos.">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputFecha">Fecha Solicitud</label>
                                                        <input name="fecha_solicitud" type="date"  class="form-control flatpickr-basic"
                                                            id="inputFecha" placeholder="Seleccione la fecha" value="<?= $candidatos['fecha_solicitud']?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="inputfile">Portafolio</label>
                                                        <input name="portafolio" type="file" accept="application/pdf" class="form-control"
                                                            id="inputfile" placeholder="nombre de su jefe inmediato">
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputdepar">Vacante a postular</label>
                                                            <select name="vacante_id" id="inputdepar"
                                                                class="form-control">
                                                                <option selected>Elegir...</option>
                                                                <?php 
                                                                    #var_dump($vacantes);
                                                                 foreach ($vacantes as $vacante):
                                                                   if ($vacante['activa']==='si') {
                                                                       
                                                                       $selected = ($vacante['id_vacante'] === $candidatos['vacante_id']) ? 'selected' : '';
                                                                       echo "<option value='{$vacante['id_vacante']}'' $selected>{$vacante['nombre']}</option>";
                                                                   }


                                                                 endforeach;      
                                                                
                                                                ?>

                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputEstado">estado de potulacion</label>
                                                            <select name="estado" id="inputEstado" class="form-control">
                                                                <?php if ($candidatos['estado']=='pendiente') { ?>
                                                                    <option value="preseleccionado">Preseleccionado</option>
                                                                    <option value="descartado">Descartado</option>
                                                                    <option value="pendiente" selected>Pendiente</option>

                                        
                                                                <?php }elseif ($candidatos['estado']=='descartado') {?>
                                                                    <option value="preseleccionado">Preseleccionado</option>
                                                                    <option value="descartado" selected>Descartado</option>
                                                                    <option value="pendiente">Pendiente</option>

                                                                <?php } else{ ?>
                                                                    <option value="preseleccionado" selected>Preseleccionado</option>
                                                                    <option value="descartado">Descartado</option>
                                                                    <option value="pendiente">Pendiente</option>

                                                                <?php }?>    
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <img alt="perfil del usuario" id="preview"
                                                            src="<?= config('App')->imgURL; ?>/avatars/default-user.png"
                                                            class="rounded-circle img-responsive mt-2" width="128"
                                                            height="128" />
                                                        <div class="mt-2">

                                                            <small>NOTA: la entrada "portafolio" Acepta solo documento .pdf de max 10MB. dimension
                                                                recomendada: documento de buena calidad</small>
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