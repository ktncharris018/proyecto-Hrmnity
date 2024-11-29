<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\HistorialModel;
use App\Models\NotificacionModel;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;

    protected $nombreUsuario;

    protected $historialModel;

    protected $notificacionModel;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();

        // Cargar el usuario desde la sesión
        $this->cargarUsuario();

        $this->historialModel = new HistorialModel();
        $this->notificacionModel = new NotificacionModel();
    }

    private function cargarUsuario() {
        $this->nombreUsuario = $this->session->get('nombre');

        // Redirigir si no hay usuario en sesión
        if (!$this->nombreUsuario) {
            return redirect()->to('/login'); // Cambia '/login' a tu ruta de inicio de sesión
        }
    }

    protected function manejarExcepcion($mensaje)
    {
        if (strpos($mensaje, 'Duplicate entry') !== false) {
            return 'El identificador ingresado ya existe. Por favor, use un identificador diferente.';
        } elseif (strpos($mensaje, 'unique constraint') !== false) {
            return 'El valor ingresado ya existe en un campo único. Por favor, revise los datos e intente nuevamente.';
        } elseif (strpos($mensaje, 'not null constraint') !== false) {
            return 'Algunos campos obligatorios están vacíos. Asegúrese de completar todos los campos requeridos.';
        } elseif (strpos($mensaje, 'foreign key constraint') !== false) {
            return 'Error con la referencia de datos. Asegúrese de que los datos relacionados existan.';
        } elseif (strpos($mensaje, 'data type') !== false) {
            return 'El tipo de datos ingresado no es válido. Por favor, revise los datos y vuelva a intentarlo.';
        } elseif (strpos($mensaje, 'data length') !== false) {
            return 'El valor ingresado excede la longitud permitida. Asegúrese de que todos los campos cumplan con las restricciones de longitud.';
        } else {
            return 'Error al crear el empleado: ' . $mensaje;
        }
    }
}
