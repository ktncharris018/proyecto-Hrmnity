<!DOCTYPE html>
<html lang="es">
<?php echo view('Layouts/head'); ?>
<?php 
    $foto = $usuario['foto_perfil']; 
    $sesion = session();
    $idUsuario = $sesion->get('usuario_id');

?>
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

					<h1 class="h3 mb-3">Perfil del Usuario</h1>

					<div class="row">
						<div class="col-md-3 col-xl-2">

							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">Configuracion</h5>
								</div>

								<div class="list-group list-group-flush" role="tablist">
									<a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab">
										Perfil
									</a>
									<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
										Contraseña
									</a>
									<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
										otro
									</a>
								</div>
							</div>
						</div>

						<div class="col-md-9 col-xl-10">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="account" role="tabpanel">

                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Detalles del Perfil</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="<?= base_url("public/uploads/img/empleados/$foto")?>" alt="foto de perfil del usuario" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                                            <h5 class="card-title mb-0"><?= $usuario['nombre'] ?></h5>
                                            <div class="text-muted mb-2"><?= $usuario['usuario'] ?></div>
                                            <div><span class='badge badge-success-light'><?= $usuario['tipo_usuario'] ?></span></div>

                                        </div>
                                        <hr class="my-0" />
                                        <div class="card-body">
                                            <h5 class="h6 card-title">Habilidades</h5>
                                            <span  class="badge bg-primary me-1 my-1">Empatia</span>
                                            <span  class="badge bg-primary me-1 my-1">liderazgo</span>
                                            <span  class="badge bg-primary me-1 my-1">comunicacion asertiva</span>
                                            <span  class="badge bg-primary me-1 my-1">gestion de contrato</span>
                                            <span  class="badge bg-primary me-1 my-1">gestion de talento</span>
                                            <span  class="badge bg-primary me-1 my-1">gestion de proyecto</span>
                                            <span  class="badge bg-primary me-1 my-1">legislacion laboral</span>
                                        </div>
                                        <hr class="my-0" />
                                        <div class="card-body">
                                            <h5 class="h6 card-title">Acerca de mi</h5>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-1"><span data-feather="mail" class=""></span> <?= $usuario['contacto'] ?></li>

                                                <li class="mb-1"><span data-feather="hash" class=""></span> cc: <?= $usuario['identificacion'] ?></li>
                                                <li class="mb-1"><span data-feather="briefcase" class=""></span> <?= $usuario['titulo'] ?></li>
                                                <li class="mb-1"><span data-feather="home" class=""></span> <?= $usuario['nombre_departamento'] ?></li>
                                            </ul>
                                        </div>
                                    </div>



								</div>
								<div class="tab-pane fade" id="password" role="tabpanel">
									<div class="card">
										<div class="card-body">
											<h5 class="card-title">Cambiar Contraseña</h5>

                                            <form method="post" class="ajax-form" action="<?= base_url('public/usuario/Update') ?>" enctype="multipart/form-data">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <input type="hidden" name="id" value="<?= $idUsuario; ?>">
												<div class="mb-3">
													<label class="form-label" for="inputPasswordCurrent">Contraseña Actual</label>
													<input type="password" class="form-control" name="contraseña_actual" id="inputPasswordCurrent">
													<small><a href="#">Forgot your password?</a></small>
												</div>
												<div class="mb-3">
													<label class="form-label" for="inputPasswordNew">Contraseña Nueva</label>
													<input type="password" class="form-control" name="contraseña_nueva" id="inputPasswordNew">
												</div>
												<button type="submit" class="btn btn-success">Actualizar</button>
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