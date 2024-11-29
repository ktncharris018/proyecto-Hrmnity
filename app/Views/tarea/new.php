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

                    <h1 class="h3 mb-3">Agregar Y Asignar Tarea</h1>

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
                                    <h5 class="card-title mb-0">Public info</h5>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" class="ajax-form" action="<?= base_url('public/tarea') ?>"
                                            enctype="multipart/form-data">
                                            <div class="">
                                                <div class="mb-3">
                                                    <label class="form-label" for="inputUsername">Nombre de la tarea</label>
                                                    <input name="nombre" type="text" class="form-control"
                                                        id="inputUsername" placeholder="Username">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripcion</label>
                                                    <textarea class="form-control" name="descripcion" placeholder="Escriba una descripcion de la vacante" rows="1"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                            <label class="form-label" for="inputEncargado">Empleado Encargado</label>
                                                            <select class="choices-multiple-remove-button form-control" multiple name="empleados[]" id="choices-multiple-remove-button" data-trigger placeholder="Eliga los empleados...">
                                                                <option >Elegir...</option>
                                                                <optgroup>

                                                                    <?php 
                                                                        #var_dump($departamentos);
                                                                    foreach ($empleados as $empleado):
                                                                    
                                                                    
                                                                        echo "
                                                                        <option value='{$empleado['id_empleado']}''>{$empleado['nombre']}</option>
                                                                        
                                                                        ";

                                                                    endforeach;      
                                                                    
                                                                    ?>
                                                                </optgroup>
                                                            </select>
                                                        </div>

                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputdepar">Progreso de la tarea</label>
                                                            <select name="progreso" id="inputdepar"
                                                                class="form-control">
                                                                <option selected>Elegir...</option>
                                                                <?php 
                                                                    #var_dump($departamentos);
                                                                 foreach ($progresoTarea as $progreso):
                                                                    echo "<option value='{$progreso}'>{$progreso} %</option>";
                                                                 endforeach;      
                                                                
                                                                ?>

                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label" for="inputEstado">Estado Activo</label>
                                                            <select name="estado" id="inputEstado" class="form-control" disabled>
                                                                <option selected>Elegir...</option>
                                                                <option value="Pendiete" selected>Pendiente</option>
                                                                <option value="En Avance">En avance</option>
                                                                <option value="Finalizada">Finalizada</option>
                                                            </select>
                                                        </div>
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
    <script src="http://localhost/hrm-system/public/static/js/choices.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Choices(
                ".choices-multiple-remove-button",
                {
                    allowHTML: true,
                    removeItemButton: true,
                }
                );
                new Choices(document.querySelector(".choices-multiples"));
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