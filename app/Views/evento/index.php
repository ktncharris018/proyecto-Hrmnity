<!DOCTYPE html>
<html lang="es">

<?php echo view('Layouts/head'); ?>
<style>
    .event-success {
        background-color: #28a745; /* Verde */
        border-color: #28a745;
    }
    .event-danger {
        background-color: #dc3545; /* Rojo */
        border-color: #dc3545;
    }
    .event-info {
        background-color: #17a2b8; /* Cian */
        border-color: #17a2b8;
    }
    .event-warning {
        background-color: #ffc107; /* Amarillo */
        border-color: #ffc107;
    }
</style>

<body>
    <div class="wrapper">
        <?php echo view('Layouts/sidebar'); ?>
        <div class="main">
            <?php echo view('Layouts/navbar'); ?>
            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Calendario de Eventos</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Empty card</h5>
                                </div>

                                <div class="card-body">
                                    <div id="calendar"></div>

									<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="eventModalLabel">Agregar evento</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
                                                
                                                    <div class="modal-body m-3">
                                                        <div class="mb-3">
                                                                <label class="form-label" for="eventName">Nombre del Evento</label>
                                                                <input name="title" type="text" class="form-control"
                                                                    id="eventName" placeholder="Escriba un nombre">
                                                            </div>
                                                        </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-secondary">Cerrar</button>
                                                        <button type="submit" class="btn btn-success" id="saveEvent">Guardar Cambios</button>
                                                    </div>
                                                   
											</div>
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
    </div>
    <?php echo view('Layouts/script-js'); ?>
    <script src="http://localhost/hrm-system/public/static/js/index.global.min.js"></script>
    <script src="http://localhost/hrm-system/public/static/js/init-calendar.js"></script>

    <script>
        var events = <?=  $eventos ?>
    </script>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: "bootstrap",
                initialView: 'dayGridMonth',
                editable: true, // Permitir arrastrar eventos
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: [],
                dateClick: function(info) {
                    $('#eventModal').modal('show');
                    $('#eventModalLabel').text('Agregar Evento');
                    $('#eventName').val('');
                    $('#deleteEvent').remove();
                    $('#saveEvent').off('click').on('click', function() {
                        const title = $('#eventName').val();
                        if (title) {
                            const randomClass = () => {
                                const classes = ['event-success', 'event-danger', 'event-info', 'event-warning'];
                                return classes[Math.floor(Math.random() * classes.length)];
                            };

                            calendar.addEvent({
                                title: title,
                                start: info.date,
                                allDay: true,
                                classNames: [randomClass()] // Asignar una clase de color aleatorio
                            });
                            $('#eventModal').modal('hide');
                        } else {
                            alert('Por favor, introduce un nombre para el evento.');
                        }
                    });
                },
                eventClick: function(info) {
                    $('#eventModal').modal('show');
                    $('#eventModalLabel').text('Editar Evento');
                    $('#eventName').val(info.event.title);
                    
                    // Eliminar cualquier botón de eliminar existente
                    $('#deleteEvent').remove();

                    $('#saveEvent').off('click').on('click', function() {
                        const title = $('#eventName').val();
                        if (title) {
                            info.event.setProp('title', title);
                            $('#eventModal').modal('hide');
                        } else {
                            alert('Por favor, introduce un nombre para el evento.');
                        }
                    });

                    // Agregar botón de eliminar
                    $('.modal-footer').append('<button type="button" class="btn btn-danger" id="deleteEvent">Eliminar Evento</button>');
                    $('#deleteEvent').off('click').on('click', function() {
                        info.event.remove();
                        $('#eventModal').modal('hide');
                    });
                    
                }
            });

            calendar.render();
        });
    </script> -->
</body>

</html>