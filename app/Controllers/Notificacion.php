<?php

namespace App\Controllers;

use App\Models\NotificacionModel;

class Notificacion extends BaseController
{
    protected $notificacionModel;

    public function __construct()
    {
        $this->notificacionModel = new NotificacionModel();
        // crear o instanciar la sesion para las notidicaciones
        $this->session = \Config\Services::session();
    }

    public function index(){
        // $notificaciones = $this->notificacionModel->obtenerNotificaciones();

        // $notificaciones = $this->formatearFechas($notificaciones);
        $this->almacenarSesion();

        return view("notificacion/index");

    }

    public function show(){
        $this->almacenarSesion();
    }

    public function almacenarSesion()
    {
        $notificaciones = $this->notificacionModel->obtenerNotificaciones();

        $notificaciones = $this->formatearFechas($notificaciones);

        if (!empty($this->session->set('notificaciones'))) {
            session()->set('notificaciones', []);
        }

        $this->session->set('notificaciones', $notificaciones);

        return;
        // sesion = $notifaciones ; en la sesion de notificaciones se debe almacenar las notificaciones del modelo

        
    }

    protected function formatearFechas($notificaciones)
    {
        foreach ($notificaciones as &$notificacion) {
            $notificacion['fecha'] = date('d \d\e F, H:i', strtotime($notificacion['fecha']));
        }

        return $notificaciones;
    }

    public function delete()
    {
        $data = $this->request->getJSON();  // Obtener el cuerpo de la solicitud JSON
        $id = $data->id ?? null;  // Extraer el ID de la notificación

        if ($id) {
            $this->notificacionModel->delete($id);  // Eliminar la notificación por ID
        }

        $this->almacenarSesion();

        return $this->response->setJSON(['status' => 'success']);  // Respondemos que fue exitoso
    }

    public function borrar(){
        
        if ($this->request->getMethod() === 'delete') {
            $id = $this->request->getJSON()->id; // Obtener ID del cuerpo JSON de la solicitud
            
            if($this->notificacionModel->delete($id)){ // eliminar en la bd

                #$this->getAlmacenarSesion(); //para actualizar la sesion
                // return $this->response->setJSON([
                //     'status' => 'success',
                //     'id'=>'',
                //     'message' => 'notificacion eliminado exitosamente.',
                //     'table' =>''
                // ]);
            }
             
        }

    }

    

}
