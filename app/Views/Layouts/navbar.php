<?php
$sesion = session();
$idUsuario = $sesion->get('usuario_id');
$foto = $sesion->get('foto_perfil');
$notificaciones = session()->get('notificaciones');

?>
<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse">
        <ul class="navbar-nav navbar-align">
            <div class="vista-notificaciones">
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
                                        <button class="btn-close btn-delete" id="" data-id="<?= $notificacion['id_notificacion']?>" data-url="<?= base_url("public/notificacion/{$notificacion['id_notificacion']}")?>"></button>
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
            </div>
            <li class="nav-item">
                <a class="nav-icon js-fullscreen d-lg-block" href="#">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="maximize"></i>
                    </div>
                </a>
            </li>
            <!-- <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="message-square"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
                    <div class="dropdown-menu-header">
                        <div class="position-relative">
                            4 New Messages
                        </div>
                    </div>
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="" class="avatar img-fluid rounded-circle"
                                        alt="Vanessa Tucker">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">Vanessa Tucker</div>
                                    <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu
                                        tortor.</div>
                                    <div class="text-muted small mt-1">15m ago</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="" class="avatar img-fluid rounded-circle"
                                        alt="William Harris">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">William Harris</div>
                                    <div class="text-muted small mt-1">Curabitur ligula sapien euismod
                                        vitae.</div>
                                    <div class="text-muted small mt-1">2h ago</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="" class="avatar img-fluid rounded-circle"
                                        alt="Christina Mason">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">Christina Mason</div>
                                    <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.
                                    </div>
                                    <div class="text-muted small mt-1">4h ago</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="" class="avatar img-fluid rounded-circle"
                                        alt="Sharon Lessman">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">Sharon Lessman</div>
                                    <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed,
                                        posuere ac, mattis non.</div>
                                    <div class="text-muted small mt-1">5h ago</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-menu-footer">
                        <a href="#" class="text-muted">Show all messages</a>
                    </div>
                </div>
            </li> -->
            <li class="nav-item dropdown">
                <!-- <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a> -->

                <a class="nav-link dropdown-toggle d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="<?= base_url("public/uploads/img/empleados/$foto")?>"
                        class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span
                        class="text-dark"><?= $sesion->get('nombre'); ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="<?= base_url("public/usuario/show/$idUsuario") ?>"><i class="align-middle me-1"
                            data-feather="user"></i> Mi Perfil</a>
                    <a class="dropdown-item" href="<?= base_url("public/dashboard") ?>"><i class="align-middle me-1" data-feather="pie-chart"></i>
                        Analisis</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i>
                        Ajustes</a>
                    <a class="dropdown-item" href="<?= base_url("public/evento") ?>"><i class="align-middle me-1" data-feather="calendar"></i> Mis Eventos</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('public/login/CerrarSesion')?>"><i class="align-middle me-1" data-feather="log-in"></i>Cerrar Sesion</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     
</script>
<script>
    $(document).ready(function() {    

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();  // Evita que el enlace haga su acción predeterminada
            
            //alert("estas el ajax de eliminar");
            console.info("estas en el metodo de eliminar ajax");
            
            var id = $(this).data('id');  // Obtener el ID de la notificación
            var actionUrl = $(this).data('url');  // URL de la acción DELETE

            // Realizamos la solicitud AJAX utilizando jQuery
            $.ajax({
                url: actionUrl,  // URL donde se realizará la solicitud DELETE
                type: 'DELETE',  // Método DELETE
                contentType: 'application/json',  // El contenido es JSON
                data: JSON.stringify({ id: id }),  // Enviamos el ID como un objeto JSON
                success: function(response) {
                    if (response.status === 'success') {
                        console.log('Notificación eliminada con éxito');
                        $('#notificacion-' + id).fadeOut(300, function() {
                            // Esto oculta el elemento y luego lo elimina del DOM
                            $(this).remove();
                        });
                        loadNotificaciones();
                        feather.replace();
                        // Aquí puedes hacer lo que quieras después de eliminar la notificación, por ejemplo:
                        // Eliminar el elemento HTML o recargar las notificaciones si es necesario
                    } else {
                        console.log('Error al eliminar la notificación');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX: ' + error);
                }
            });
        });

        function loadNotificaciones() {
            const url = 'http://localhost/hrm-system/public/notificacion';

            fetch(url) // Cambia esta URL a la ubicación de tu archivo cards.php
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.vista-notificaciones').innerHTML = html; // Asume que tus cards están dentro de un contenedor con la clase .
                    feather.replace(); 

                })
                .catch(error => {
                    console.error('Error al cargar las notificaciones:', error);
                });
        }


    });
</script>