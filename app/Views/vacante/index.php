<!DOCTYPE html>
<html lang="es">

<?php echo view('Layouts/head'); ?>

<body>
    <div class="wrapper">
        <?php echo view('Layouts/sidebar'); ?>
        <div class="main">
            <?php echo view('Layouts/navbar'); ?>
			<main class="content">
				<div class="container-fluid p-0">

					<a href="<?=base_url('public/vacante/new')?>" class="btn btn-primary float-end mt-n1"><i class="fas fa-plus"></i>Add</a>
					<div class="mb-3">
						<h1 class="h3 d-inline align-middle">Vacantes</h1>
					</div>

					<div class="row load-cards">
					<?php
						foreach ($vacantes as $vacante):
					?>
						<div class="col-12 col-lg-6">
							<div class="card">
								<div class="card-header">
									<div class="card-actions float-end">
										<div class="dropdown position-relative">
											<a href="#" data-bs-toggle="dropdown" data-bs-display="static">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
											</a>

											<div class="dropdown-menu dropdown-menu-end">
												<a class="dropdown-item" href="<?= base_url("public/vacante/{$vacante['id_vacante']}/edit") ?>" data>Editar</a>
												<button class="dropdown-item btn btn-eliminar-cards" type="button" data-id="<?= $vacante['id_vacante']?>" data-url="<?= base_url("public/vacante/{$vacante['id_vacante']}") ?>">Eliminar</button>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</div>

								
									<ul class="nav nav-tabs card-header-tabs pull-right" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#tab-1<?= $vacante['id_vacante']?>">Principal</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#tab-2<?= $vacante['id_vacante']?>">Detalles</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-bs-toggle="tab" href="#tab-3<?= $vacante['id_vacante']?>">Disabled</a>
										</li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane fade show active" id="tab-1<?= $vacante['id_vacante']?>" role="tabpanel">
											<h5 class=" fw-bold"><?= $vacante['nombre']?> - <?=$vacante['titulo_profesional'] ?></h5>
											<p class="card-text fst-italic"><?=$vacante['descripcion'] ?></p>
										</div>
										<div class="tab-pane fade" id="tab-2<?= $vacante['id_vacante']?>" role="tabpanel">
											<h5 class="fw-bold">Encargado:</h5>
											<p class="card-text"><?=$vacante['encargado'] ?></p>
											<h5 class="fw-bold">Departamento:</h5>
											<p class="card-text"><?=$vacante['departamento'] ?></p>
											<h5 class="fw-bold">Estado Activo:</h5>
											<p class="card-text"><?=$vacante['activa'] ?></p>
										</div>
										<div class="tab-pane fade" id="tab-3" role="tabpanel">
											<h5 class="card-title">Card with tabs</h5>
											<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach?>		
						<!-- <div class="col-12 col-lg-6">
							<div class="card">
								<div class="card-header">
									<div class="card-actions float-end">
										<div class="dropdown position-relative">
											<a href="#" data-bs-toggle="dropdown" data-bs-display="static">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
											</a>

											<div class="dropdown-menu dropdown-menu-end">
												<a class="dropdown-item" href="#">Editar</a>
												<a class="dropdown-item" href="#">Eliminar</a>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</div>

								
									<ul class="nav nav-tabs card-header-tabs pull-right" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#tab-1">Active</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#tab-2">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-bs-toggle="tab" href="#tab-3">Disabled</a>
										</li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane fade show active" id="tab-1" role="tabpanel">
											<h5 class="card-title">Card with tabs</h5>
											<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.
											</p>
											<a href="#" class="btn btn-primary">Go somewhere</a>
										</div>
										<div class="tab-pane fade text-center" id="tab-2" role="tabpanel">
											<h5 class="card-title">Card with tabs</h5>
											<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.
											</p>
											<a href="#" class="btn btn-primary">Go somewhere</a>
										</div>
										<div class="tab-pane fade" id="tab-3" role="tabpanel">
											<h5 class="card-title">Card with tabs</h5>
											<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.
											</p>
											<a href="#" class="btn btn-primary">Go somewhere</a>
										</div>
									</div>
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</main>
			<?php echo view('Layouts/footer'); ?>
        </div>
    </div>
    </div>
    <?php echo view('Layouts/script-js'); ?>
</body>

</html>