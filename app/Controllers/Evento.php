<?php

namespace App\Controllers;

use App\Models\EventoModel;

class Evento extends BaseController
{
    protected $eventoModel;

    public function __construct() {
        $this->eventoModel = new EventoModel();
    }

    // Método para mostrar la vista del calendario
    public function index() {
        // Obtener todos los eventos
        $eventos = $this->eventoModel->obtenerEventos();
        // Pasar los eventos como JSON a la vista
        return view('evento/index', ['eventos' => json_encode($eventos)]);
    }

    // Obtener todos los eventos (para AJAX)
    public function fetchEvents() {
        $events = $this->eventoModel->findAll();
        return $this->response->setJSON($events);
    }

    // Agregar un nuevo evento
    public function create() {
        $data = [
            'title' => $this->request->getPost('title'),
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('end'),
            'className' => $this->request->getPost('className')
        ];
        $this->eventoModel->insert($data);
        return $this->response->setJSON(['status' => 'success', 'message'=>'Evento guardado']);
    }

    // Actualizar un evento
    public function update($id) {
        $data = json_decode($this->request->getBody(), true); // Decodificar el JSON recibido
        $title = $data['title']; // Obtener el título
        $start = $data['start']; // Obtener la fecha (start)
        #$title = $this->request->getPost('title');
        #$start = $this->request->getPost('start');
        $data = [
            'title' => $title,
            'start' => $start
        ];

        log_message('debug', print_r($data, true));


        if ($id) {
            $this->eventoModel->update($id, $data);
            return $this->response->setJSON(['status' => 'success']);
            # code...
        }
    }

    // Eliminar un evento
    public function delete($id) {
        $this->eventoModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}
