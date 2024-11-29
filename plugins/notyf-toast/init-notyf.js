// Crear una instancia de Notyf con la configuración deseada
const notyf = new Notyf({
    duration: 10000,
    position: {
        x: 'center',
        y: 'top'
    },
    dismissible: true
});

// Función para mostrar notificaciones
// function showNotification(type, message) {
//     if (type === 'success') {
//         notyf.success(message);
//     } else if (type === 'error') {
//         notyf.error(message);
//     }
// }

