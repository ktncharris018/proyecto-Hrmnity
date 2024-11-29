<?php
$notificaciones = session()->get('notificaciones');
?>

<li class="nav-item dropdown">
    <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown" aria-expanded="false"
        data-bs-auto-close="outside">
        <div class="position-relative">
            <i class="align-middle" data-feather="bell"></i>
            <span class="indicator"><?= $contador = empty($notificaciones)? 0 : count($notificaciones)  ?></span>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
        <div class="dropdown-menu-header">
            <?= $contador ?> Nuevas Notificationes
        </div>
        <?php 
        if (isset($notificaciones)): 
            foreach ($notificaciones as $notificacion):
        ?>
        <div class="list-group" id="notificacion-<?= $notificacion['id_notificacion']?>">
            <div class="list-group-item">
                <div class="row g-0 align-items-center">
                    <div class="col-2">
                        <i class="text-primary" data-feather="info"></i>
                    </div>
                    <div class="col-8">
                        <div class="text-dark"><?= $notificacion['titulo'] ?></div>
                        <div class="text-muted small mt-1"><?= $notificacion['descripcion'] ?></div>
                        <div class="text-muted small mt-1"><?= $notificacion['fecha'] ?></div>
                    </div>
                    <div class="d-flex col-2 justify-content-end">
                        <button type="button" class="btn-close btn-delete" id="7" data-id="<?= $notificacion['id_notificacion']?>" data-url="<?= base_url("public/notificacion/{$notificacion['id_notificacion']}")?>"></button>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            endforeach;
        endif    
        ?>
        <div class="dropdown-menu-footer">
            <a href="#" class="text-muted">Show all notifications</a>
        </div>
    </div>
</li>
