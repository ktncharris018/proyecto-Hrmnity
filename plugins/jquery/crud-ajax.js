/**
 * Maneja el envío de formularios AJAX para creación y actualización.
 * @param {string} url - URL a la que se enviarán los datos del formulario.
 * @param {string} method - Método HTTP a utilizar (POST, PUT, etc.).
 * @param {FormData} data - Datos del formulario a enviar.
 * @returns {Promise<object>} - Promesa que resuelve con la respuesta del servidor.
 */
 function handleFormSubmission(url, method, data) {
    return fetch(url, {
        method: method,
        body: data,
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // Para diferenciar solicitudes AJAX en el servidor
        }
    })
    .then(response => response.json())
    .then(data => {
        return data; // Devuelve los datos para que puedan ser manejados
    });
}

/**
 * Muestra una notificación usando Notyf.
 * @param {string} type - Tipo de mensaje ('success' o 'error').
 * @param {string} message - Mensaje a mostrar.
 */
function showNotification(type, message) {
    const notyf = new Notyf({
        duration: 10000,
        position: {
            x: 'center',
            y: 'top'
        },
        dismissible: true
    });
    // const notyf = new Notyf();
    if (type === 'success') {
        notyf.success(message);
    } else if (type === 'error') {
        notyf.error(message);

    }else if (type==='warning') {
        const warningNotyf = new Notyf({
            duration: 10000,
            position: {
              x: 'center',
              y: 'top',
            },
            dismissible: true,
            types: [
              {
                type: 'warning',
                background: 'orange',
                icon: {
                    className: 'align-middle', // Clase adicional para alineación
                    tagName: 'span', // Etiqueta que se usará
                    text: '⚠️' // Emoji de advertencia
                }
              },
            ]
        });

        warningNotyf.open({
            type: 'warning',
            message: message
        });
        
    } else {
        console.warn('Tipo de mensaje desconocido: ', type);
    }
}

/**
 * Maneja el envío de formularios AJAX para creación y actualización.
 */
document.addEventListener('DOMContentLoaded', function() {

    const flashMessage = document.getElementById('flash-message');
    if (flashMessage && flashMessage.getAttribute('data-message')) {
        const message = flashMessage.getAttribute('data-message');
        showNotification('error', message);
        setTimeout(() => {
            window.location.href = "http://localhost/hrm-system/public/login"; 
        }, 5000);
    }

    
    // Manejar el envío de formularios para creación y actualización
    document.addEventListener('submit', function(e) {
        if (e.target.matches('.ajax-form')) {
            e.preventDefault(); // Evita el comportamiento de envío tradicional

            const form = e.target;
            const formData = new FormData(form);
            const actionUrl = form.action;
            const method = form.method || 'POST'; // Usa POST por defecto si no se especifica el método

            handleFormSubmission(actionUrl, method, formData)
                .then(response => {
                    // Maneja la respuesta en función del estado
                    showNotification(response.status, response.message);
                    if (response.status === 'success') {
                        form.reset(); // Opcional: Resetear el formulario

                        loadNotificaciones();

                        if (response.vista=='empleado') {
                            
                            document.getElementById('preview').src = 'http://localhost/hrm-system/public/static/img//avatars/default-user.png';
                        }
                    }

                    if (response.tipo == 'update') {
                        console.log(response.redirect);

                        setTimeout(() => {
                            window.location.href = response.redirect; 
                        }, 2000);
                        
                    }
                    //redirige a la pagina deseada despues de logearse
                    if (response.tipo == 'login') {
                        console.log(response.redirect);

                        setTimeout(() => {
                            window.location.href = response.redirect; 
                        }, 2000);
                        
                    }
                })
                .catch((error) => {
                    // Maneja errores en el envío
                    confirm(error.message);
                    console.log(error.message);
                    showNotification('error', error.message);
                });
        }
    });

    $(document).ready(function() {
    
        $(document).on('click', '.btn-eliminar', function(e) {
            e.preventDefault(); // Evita la acción predeterminada del enlace
    
            const $row = $(this).closest('tr'); // Encuentra la fila más cercana al botón
            const id = $(this).data('id');
            const actionUrl = $(this).data('url');
            
            if (confirm('¿Estás seguro de que deseas eliminar este registro? '+id+actionUrl+' ?')) {
                console.log(id);
                console.log(actionUrl);
            
                $row.fadeOut(300, function() {
                    // Realiza la eliminación en el servidor
                    fetch(actionUrl, {
                        method: 'DELETE', 
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest' // Para diferenciar solicitudes AJAX en el servidor
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showNotification(data.status, data.message);
                            

                        } else {
                            showNotification('error', 'Error al eliminar el recurso.');
                            // Muestra la fila nuevamente si hay un error
                            $row.fadeIn(300);
                        }
                    })
                    .catch((error) => {
                        showNotification('error', error.message);
                        console.error(error.message);
                        $row.fadeIn(300);
                    });
                });

               
            }
        });


    
       
        $(document).on('click', '.btn-eliminar-cards', function(e) {
            e.preventDefault(); // Evita la acción predeterminada del enlace
    
            const id = $(this).data('id');
            const actionUrl = $(this).data('url');
            
            if (confirm('¿Estás seguro de que deseas eliminar este elemento? '+id+actionUrl+' ?')) {
                console.log(id);
                console.log(actionUrl);
                         
                    // Realiza la eliminación en el servidor
                    fetch(actionUrl, {
                        method: 'DELETE', // Usualmente DELETE para eliminación
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest' // Para diferenciar solicitudes AJAX en el servidor
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showNotification(data.status, data.message);
                            loadCards(data.vista)
                            
                        } else {
                            showNotification('error', 'Error al eliminar el recurso.');
                            // Muestra la fila nuevamente si hay un error
                            $row.fadeIn(300);
                        }
                    })
                    .catch((error) => {
                        showNotification('error', error.message);
                        console.error(error.message);
                        $row.fadeIn(300);
                    });
                

               
            }
        });

        function loadCards(vista) {
            const url = `http://localhost/hrm-system/public/${vista}/show`;

            fetch(url) // Cambia esta URL a la ubicación de tu archivo cards.php
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.load-cards').innerHTML = html; // Asume que tus cards están dentro de un contenedor con la clase "row"
                })
                .catch(error => {
                    console.error('Error al cargar los cards:', error);
                });
        }
        
        
        
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
   
    
    
    //Manejar el clic en enlaces de eliminación
/*     document.addEventListener('click', function(e) {
        if (e.target.matches('.btn-eliminar')) {
            e.preventDefault(); // Evita la acción predeterminada del enlace
            confirm('has presionado el boton');
            const id = e.target.getAttribute('data-id');
            const actionUrl = e.target.getAttribute('data-url');
            console.log(actionUrl);

            if (confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
                fetch(actionUrl, {
                    method: 'delete', // Usualmente DELETE para eliminación
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // Para diferenciar solicitudes AJAX en el servidor
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    showNotification(data.status, data.message);

                    if (data.status === 'success') {

                        //document.getElementById('divtable').innerHTML = data.table;
                       // initializeDataTable();

                    }
                })
                .catch(() => {
                    showNotification('error', 'Error al eliminar el recurso.');
                });
            }
        }
    });
 */    
});
