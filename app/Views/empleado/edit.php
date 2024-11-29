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

                    <h1 class="h3 mb-3">Settings</h1>

                    <div class="row">
                        <div class="col-md-3 col-xl-2" style="display:none">

                            <div class="card" >
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Profile Settings</h5>
                                </div>

                                <div class="list-group list-group-flush" role="tablist">
                                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list"
                                        href="#account" role="tab">
                                        Account
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-bs-toggle="list"
                                        href="#password" role="tab">
                                        Password
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#"
                                        role="tab">
                                        Privacy and safety
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#"
                                        role="tab">
                                        Email notifications
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#"
                                        role="tab">
                                        Web notifications
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#"
                                        role="tab">
                                        Widgets
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#"
                                        role="tab">
                                        Your data
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#"
                                        role="tab">
                                        Delete account
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-xl-12">
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
                                    <?= \Config\Services::validation()->listErrors(); ?>

                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Public info</h5>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" class="ajax-form" action="<?= base_url('public/empleado/update') ?>" enctype="multipart/form-data">
                                                
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="id" value="<?= $empleado['id_empleado']; ?>">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="inputUsername">Nombre del
                                                                empleado</label>
                                                            <input name="nombre" type="text" class="form-control"
                                                                id="inputUsername" placeholder="Username" value="<?= $empleado['nombre']; ?>" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="inputidentificacion">Identificacion empleado</label>
                                                            <input name="identificacion" type="text" class="form-control"
                                                                id="inputidentificacion" placeholder="identificcion"
                                                                maxlength="10" pattern="\d{1,10}" value="<?= $empleado['identificacion']; ?>"
                                                                title="El número debe ser numérico y tener entre 1 y 10 dígitos.">
                                                        </div>
                                                        <div class="mb-3">
                                                        <label class="form-label" for="inputcontacto">Correo Electronico</label>
                                                        <input name="contacto" type="email" class="form-control"
                                                            id="inputcontacto" placeholder="direccion de correo" value="<?= $empleado['contacto']?>"
                                                            title="Recuerde seguir esta estructura nombre@dominio.com">
                                                    </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="inputprofesion">profesion</label>
                                                            <input name="titulo" type="text" class="form-control" value="<?= $empleado['titulo']; ?>"
                                                                id="inputprofesion" placeholder="titlo de profesion">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="inputsupervisor">Supervisor</label>
                                                            <input name="supervisor" type="text" class="form-control" value="<?= $empleado['supervisor']; ?>"
                                                                id="inputsupervisor" placeholder="nombre de su jefe inmediato">
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="inputdepar">Departamento</label>
                                                                <select name="departamento_id" id="inputdepar" class="form-control">
                                                                <?php 
                                                                    foreach ($departamentos as $departamento):
                                                                        if ($departamento['estado'] === 'activo') {
                                                                            // Verifica si el departamento es el seleccionado
                                                                            $selected = ($departamento['id_departamento'] === $empleado['departamento_id']) ? 'selected' : '';
                                                                            echo "<option value='{$departamento['id_departamento']}' $selected>{$departamento['nombre']}</option>";
                                                                        }
                                                                    endforeach;      
                                                                ?>

                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label" for="inputcontrato">Tipo de
                                                                    contrato</label>
                                                                <select name="tipo_contrato" id="inputcontrato" class="form-control">
                                                                    <?php  
                                                                        $contrato = $empleado['tipo_contrato'] ;
                                                                        $foto = $empleado['foto_perfil'];
                                                                        if ($contrato=="independiente") {
                                                                    ?>
                                                                        <option selected value="independiente">Independiente</option>
                                                                        <option value="temporal">Temporal</option>
                                                                        <option value="fijo">Fijo</option>
                                                                        <option value="indefinido">Indefinido</option>

                                                                   <?php } elseif($contrato=="temporal") { ?>

                                                                        <option value="independiente">Independiente</option>
                                                                        <option selected value="temporal">Temporal</option>
                                                                        <option value="fijo">Fijo</option>
                                                                        <option value="indefinido">Indefinido</option>

                                                                   <?php }elseif ($contrato=="fijo") { ?>
                                                                  
                                                                        <option value="independiente">Independiente</option>
                                                                        <option value="temporal">Temporal</option>
                                                                        <option selected value="fijo">Fijo</option>
                                                                        <option value="indefinido">Indefinido</option>

                                                                    <?php }else{  ?>
                                                                        <option value="independiente">Independiente</option>
                                                                        <option value="temporal">Temporal</option>
                                                                        <option value="fijo">Fijo</option>
                                                                        <option selected value="indefinido">Indefinido</option>

                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-center">
                                                            <img alt="perfil del usuario" id="preview"
                                                                src="<?= 
                                                                        
                                                                        base_url("public/uploads/img/empleados/$foto");

                                                                    ?>"
                                                                class="rounded-circle img-responsive mt-2" width="128"
                                                                height="128" />
                                                            <div class="mt-2">
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="document.getElementById('file-input').click();"><i
                                                                        class="align-middle" data-feather="upload"></i>
                                                                    Upload</button>
                                                            </div>
                                                            <small>Acepta .jpg, .png, .jpeg de max 2MB. dimension
                                                                recomendada: 200px X 200px</small>
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
                                                    <input type="password" class="form-control"
                                                        id="inputPasswordCurrent">
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

                </div>
            </main>
            <?php echo view('Layouts/footer'); ?>
        </div>
    </div>

    <?php echo view('Layouts/script-js'); ?>
    <script>
     // Obtener el input file y la imagen de previsualización
        const fileInput = document.getElementById('file-input');
        const previewImage = document.getElementById('preview');

        fileInput.addEventListener('change', function() {
            // Verificar si se ha seleccionado un archivo
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();

                // Cuando el archivo se haya leído, actualizar el src de la imagen de previsualización
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }

                // Leer el archivo como una URL de datos
                reader.readAsDataURL(file);
            } else {
                // Limpiar la previsualización si no se selecciona ningún archivo
                previewImage.src = '';
            }
        });
    </script>


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
</body>

</html>