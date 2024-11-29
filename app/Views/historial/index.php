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

                    <h1 class="h3 mb-3">Historial de Accion</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">visualizacion</h5>
                                </div>
                                <div class="card-body">
                                    <strong>Lista de acciones</strong>
    
                                    <ul class="timeline mt-2 mb-0">
                                        <?php foreach ($historiales as $historial): ?>
                                            <li class="timeline-item">
                                                <strong><?= $historial['tipo'] ?></strong>
                                                <span class="float-end text-muted text-sm"><?= $historial['fecha'] ?></span>
                                                <p><?= $historial['descripcion'] ?></p>
                                            </li>
                                         <?php endforeach ?>   
                                        <!-- <li class="timeline-item">
                                            <strong>Created invoice #1204</strong>
                                            <span class="float-end text-muted text-sm">2h ago</span>
                                            <p>Sed aliquam ultrices mauris. Integer ante arcu...</p>
                                        </li>
                                        <li class="timeline-item">
                                            <strong>Discarded invoice #1147</strong>
                                            <span class="float-end text-muted text-sm">3h ago</span>
                                            <p>Nam pretium turpis et arcu. Duis arcu tortor, suscipit...</p>
                                        </li>
                                        <li class="timeline-item">
                                            <strong>Signed in</strong>
                                            <span class="float-end text-muted text-sm">3h ago</span>
                                            <p>Curabitur ligula sapien, tincidunt non, euismod vitae...</p>
                                        </li>
                                        <li class="timeline-item">
                                            <strong>Signed up</strong>
                                            <span class="float-end text-muted text-sm">2d ago</span>
                                            <p>Sed aliquam ultrices mauris. Integer ante arcu...</p>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
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