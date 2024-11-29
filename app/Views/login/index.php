<!DOCTYPE html>
<html lang="es">
	<?php echo view('Layouts/head'); ?>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">LOGIN</h1>
							<p class="lead">
								Inicie sesion para acceder al sistema HRMnity
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="post" class="ajax-form" action="<?= base_url('public/login/IniciarSesion') ?>" enctype="multipart/form-data">
										<div class="mb-3">
											<label class="form-label">Usuario</label>
											<input class="form-control form-control-lg" type="text" name="usuario" placeholder="Ingrese su usuario" />
										</div>
										<div class="mb-3">
											<label class="form-label">Contraseña</label>
											<input class="form-control form-control-lg" type="password" name="contraseña" placeholder="Ingrese su contraseña" />
										</div>
										<div>
											<div class="form-check align-items-center">
												<input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
												<label class="form-check-label text-small" for="customControlInline">Recordar</label>
											</div>
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg  btn-primary">Iniciar Sesion</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- <div class="text-center mb-3">
							Don't have an account? <a href="pages-sign-up.html">Sign up</a>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</main>
	<div id="flash-message" style="display: none;" data-message="<?php echo session()->getFlashdata('error'); ?>"></div>

	<?php echo view('Layouts/script-js'); ?>

</body>

</html>