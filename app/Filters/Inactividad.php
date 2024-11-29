<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Inactividad implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();

        // Verificar si el usuario está logueado
        if (!$session->get('login')) {
            if ($request->getUri()->getPath() === '/login') {
                return; // Permitir el acceso a la página de login
            }
            $login = base_url('public/login');
            // Redirigir a la página de login si no está logueado
            return redirect()->to('public/login')->with('error', 'Por favor inicie sesión para acceder al sistema.');
        }

        // Tiempo de inactividad permitido en segundos (ejemplo: 15 minutos es igual 900)
        $tiempo_inactividad_permitido = 900;

        // Obtener el tiempo de la última actividad
        $ultima_actividad = $session->get('ultima_actividad');

        if ($session->get('ultima_actividad')) {
            // Calcular el tiempo transcurrido desde la última actividad
            $tiempo_transcurrido = time() - $ultima_actividad;

            if ($tiempo_transcurrido > $tiempo_inactividad_permitido) {
                // Establecer un mensaje flash antes de cerrar la sesión
                $session->setFlashdata('error', 'Su Sesión fue cerrada por inactividad.');
                $session->destroy();
                
                    # code...
                redirect()->to('public/login');
               
                #return redirect()->to("public/{$request->getUri()->getPath()}");
                #return redirect()->to('public/login')->with('error', 'La Sesion sera cerrada por inactividad.');

                
            }
        }

        // Actualizar la última actividad
        $session->set('ultima_actividad', time());
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Lógica después de la ejecución del controlador (si es necesario)
    }
}

?>
