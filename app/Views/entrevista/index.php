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

					<a href="<?=base_url('public/entrevista/new')?>" class="btn btn-primary float-end mt-n1"><i class="fas fa-plus"></i>Add</a>
					<div class="mb-3">
						<h1 class="h3 d-inline align-middle">Entrevistas de candidato</h1>
					</div>

					<div class="row load-cards">
					<?php foreach ($entrevistas as  $entrevista): ?>
						
						<div class="col-12 col-md-6 col-lg-4">
							<div class="card">

								<div class="card-header px-4 pt-4">
									<div class="card-actions float-end">
										<div class="dropdown position-relative">
											<a href="" data-bs-toggle="dropdown" data-bs-display="static">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
											</a>

											<div class="dropdown-menu dropdown-menu-end">
												<a class="dropdown-item" href="<?=base_url("public/entrevista/{$entrevista['id_entrevista']}/edit")?>" >Editar</a>
												<a class="dropdown-item btn btn-eliminar-cards " data-id="<?= $entrevista['id_entrevista']?>" data-url="<?= base_url("public/entrevista/{$entrevista['id_entrevista']}") ?>">Eliminar</a>
												<a class="dropdown-item" href="">Otros</a>
											</div>
										</div>
									</div>
									<h5 class="fw-bold mb-0"><?= $entrevista['candidato'] ?></h5>
									<?php 
										if ($entrevista['estado']=='contratado') {
											echo "<div class='badge bg-success my-2'> {$entrevista['estado']} </div>";
										} else if ($entrevista['estado']=='rechazado') {
											echo "<div class='badge bg-danger my-2'> {$entrevista['estado']} </div>";
										}else{
											echo "<div class='badge bg-primary my-2'> {$entrevista['estado']} </div>";
										}
									?>
								</div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">Fecha: <?= $entrevista['fecha'] ?></li>
									<li class="list-group-item">Obs: <?= $entrevista['observacion'] ?></li>
									<li class="list-group-item">
										<a href="http://localhost/hrm-system/public/uploads/archivos/entrevistas/<?= $entrevista['soportes']?>" class="card-link" target="_blank">Ver soporte</a>
										<a href="#" class="card-link text-reset">otro</a>
									</li>
								</ul>
							</div>
						</div>
					<?php endforeach ?>	
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