document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        themeSystem: "bootstrap",
        initialView: 'dayGridMonth',
        editable: true, // Permitir arrastrar eventos
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
        },
        events: events, // Usar eventos cargados

        dateClick: function(info) {
            const randomClass = () => {
                const classes = ['event-success', 'event-danger', 'event-info', 'event-warning'];
                return classes[Math.floor(Math.random() * classes.length)];
            };
            $('#eventName').val('');
            $('#eventModal').modal('show');
            $('#eventModalLabel').text('Agregar Evento');
            $('#claseEvento').val([randomClass()]);
            $('#fechaEvento').val(info.dateStr);
            $('#deleteEvent').remove();
            $('#saveEvent').off('click').on('click', function() {
                $('#deleteEvent').remove();
                let title = $('#eventName').val();
                let start = info.dateStr;
                let className = [randomClass()];
                if (title) {
                    $.post('http://localhost/hrm-system/public/evento', { title: title, start: start, className: className }, function(response) {
                    calendar.addEvent({
                        title: title,
                        start: start,
                        className: className
                    });
                    $('#eventModal').modal('hide');
                    });
                    
                } else {
                    alert('Por favor, introduce un nombre para el evento.');
                }
            });
        },

        eventClick: function(info) {
            $('#eventName').val(info.event.title);
            $('#eventModal').modal('show');
            $('#deleteEvent').remove();

            $('#saveEvent').off().on('click', function() {
                let titleName = $('#eventName').val();
                let date = info.event.start.toISOString();
                updateEvent(titleName, info)
                $('#eventModal').modal('hide');
            });

            $('.modal-footer').append('<button type="button" class="btn btn-danger" id="deleteEvent">Eliminar Evento</button>');
            $('#deleteEvent').off().on('click', function() {
                $.ajax({
                    url: 'http://localhost/hrm-system/public/evento/' + info.event.id,
                    type: 'DELETE',
                    success: function(response) {
                    }
                });
                info.event.remove();
                $('#eventModal').modal('hide');
                $('#deleteEvent').remove();

            });
        },

        eventDrop: function(info) {
            const titleName = info.event.title; // Obtener el título actual
            updateEvent(titleName, info); // Llama a la función al arrastrar el evento
        }

                
    });

    calendar.render();
});

function updateEvent(titleName, info) {
    const eventId = info.event.id; // Obtener el ID del evento
    const eventStart = info.event.start.toISOString(); // Obtener la fecha de inicio

    fetch('http://localhost/hrm-system/public/evento/' + eventId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            title: titleName,
            start: eventStart
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            info.event.setProp('title', titleName); // Actualizar el título en el calendario
            info.event.setStart(eventStart); // Actualizar la fecha de inicio en el calendario
            $('#eventModal').modal('hide'); // Cerrar el modal
        } else {
            console.error('Error updating event:', data);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
