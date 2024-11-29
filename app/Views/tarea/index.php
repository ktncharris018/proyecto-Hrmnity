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

					<a href="<?=base_url('public/tarea/new')?>" class="btn btn-primary float-end mt-n1"><i class="fas fa-plus"></i>Add</a>
					<div class="mb-3">
						<h1 class="h3 d-inline align-middle">Tareas Asignadas</h1>
					</div>
					<div class="row load-cards">
						<!-- <div class="col-12 col-md-6 col-lg-3">
							<div class="card">

								<div class="card-header px-4 pt-4">
									<div class="card-actions float-end">
										<div class="dropdown position-relative">
											<a href="#" data-bs-toggle="dropdown" data-bs-display="static">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
											</a>

											<div class="dropdown-menu dropdown-menu-end">
												<a class="dropdown-item" href="#">Action</a>
												<a class="dropdown-item" href="#">Another action</a>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</div>
									<h5 class="card-title mb-0">Landing page redesign</h5>
									<div class="badge bg-success my-2">Finished</div>
								</div>
								<div class="card-body px-4 pt-2">
									<p>Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque
										sed ipsum.</p>

									<img src="./Projects_files/avatar-3.jpg" class="rounded-circle me-1" alt="Avatar" width="28" height="28">
									<img src="./Projects_files/avatar-2.jpg" class="rounded-circle me-1" alt="Avatar" width="28" height="28">
									<img src="./Projects_files/avatar.jpg" class="rounded-circle me-1" alt="Avatar" width="28" height="28">
								</div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item px-4 pb-4">
										<p class="mb-2 font-weight-bold">Progress <span class="float-end">100%</span></p>
										<div class="progress progress-sm">
											<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div> -->
					<?php foreach ($tareas as $tarea):?>
						
						<div class="col-12 col-md-6 col-lg-3">
							<div class="card">

								<img class="card-img-top" src="http://localhost/hrm-system/public/static/img/icons/tarea_icono_4.png" alt="Unsplash">

								<div class="card-header px-4 pt-4">
									<div class="card-actions float-end">
										<div class="dropdown position-relative">
											<a href="#" data-bs-toggle="dropdown" data-bs-display="static">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
											</a>

											<div class="dropdown-menu dropdown-menu-end">
												<a class="dropdown-item" href="<?= base_url("public/tarea/{$tarea['id_tarea']}/edit") ?>">Editar</a>
												<button class="dropdown-item btn btn-eliminar-cards" type="button" data-id="<?= $tarea['id_tarea']?>" data-url="<?= base_url("public/tarea/{$tarea['id_tarea']}") ?>">Eliminar</button>
												<a class="dropdown-item" href="#">Otro</a>
											</div>
										</div>
									</div>
									<h5 class="card-title mb-0"><?= $tarea["nombre"] ?></h5>
									<?php
										if ($tarea['estado']==='Pendiente') {
											$color = "bg-primary";
										} else if($tarea['estado']==='En avance') {
											$color ="bg-warning";
											
										}else{
											$color = "bg-success";

										}
										
									?>
									<div class="badge <?=$color ?> my-2"><?= $tarea["estado"] ?></div>
								</div>
								<div class="card-body px-4 pt-2">
									<p><?= $tarea["descripcion"] ?></p>
									<?php foreach ($tarea['empleados'] as $empleado): ?>

									<img src="<?= base_url("public/uploads/img/empleados/{$empleado['foto_empleado']}"); ?>" title="<?= $empleado['nombre_empleado']?>" class="rounded-circle me-1" alt="foto perfil empleado" width="28" height="28">
									<?php endforeach ?>
								</div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item px-4 pb-4">
										<p class="mb-2 font-weight-bold">Progreso<span class="float-end"><?= $tarea["progreso"] ?>%</span></p>
										<progress class="w-100" value="<?= $tarea["progreso"] ?>" max="100"></progress>
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