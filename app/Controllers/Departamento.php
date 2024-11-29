<?php

namespace App\Controllers;

use App\Models\DepartamentoModel;

class Departamento extends BaseController{

    protected $departamentoModel;

    public function __construct(){

        $this->departamentoModel = new DepartamentoModel();
    }

    public function index(){

        $lista = $this->departamentoModel->obtenerDepartamentos();

        return view('departamento/index', ['departamentos'=>$lista]);
    }

    public function new(){
        return view('departamento/new');
    }

   

    public function create(){

        if ($this->request->getMethod() ==='POST') {
            
            $data =[
                'nombre'=> $this->request->getPost('nombre'),
                'estado'=> $this->request->getPost('estado')
            ];
            
            $mensajeNotificacion = "Se ha actualizado el departamento con nombre {$data['nombre']}";

            try {
                
                $this->departamentoModel->insert($data);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $data['nombre'], $this->departamentoModel->table );
                $this->notificacionModel->insertarNotificacion($this->departamentoModel->table, $mensajeNotificacion);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Departamento creado exitosamente.',
                    'redirect' => base_url('public/departamento/new') // Redirige a la vista de la tabla
                ]);

            } catch (\Exception $e) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear el departamento: ' . $e->getMessage()
                ]);

            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar el departamento.'
        ]);
    }

    public function edit($id){

        $departamento = $this->departamentoModel->devolverdepartamento($id);

        if (!$departamento) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Departamento no encontrado con ID: ' . $id);
        }

        $data['departamento'] = $departamento;
        return view('departamento/edit', $data);

    }

    public function update(){

        $id = $this->request->getPost('id');


        $data =[
            'nombre'=> $this->request->getPost('nombre'),
            'estado'=> $this->request->getPost('estado')
        ];

        $mensajeNotificacion = "Se ha actualizado el departamento con nombre {$data['nombre']}";

        try {
            if ($id) {
                // Actualizar registro existente
                $this->departamentoModel->update($id, $data);
                $this->historialModel->registrarAccion("actualizacion", $this->nombreUsuario, $data['nombre'], $this->departamentoModel->table );
                $this->notificacionModel->insertarNotificacion($this->departamentoModel->table, $mensajeNotificacion);
                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'update', 
                    'message' => 'Departamento actualizado correctamente.',
                    'redirect' => base_url('public/departamento/') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->departamentoModel->insert($data);
                $response = ['status' => 'success', 'message' => 'Departamento creado exitosamente.'];
            }
        } catch (\Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al procesar la solicitud.'];
        }

        return $this->response->setJSON($response);

    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getJSON()->id; // Obtener ID del cuerpo JSON de la solicitud
            $data = $this->departamentoModel->devolverDepartamento($id);
            
            
            if ($this->departamentoModel->delete($id)) {
                $this->historialModel->registrarAccion("eliminacion", $this->nombreUsuario, $data['nombre'], $this->departamentoModel->table );
                $view = null;
                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'Departamento eliminado exitosamente.',
                    'table' =>$view
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar el departamento.'
                ]);
            }
        }
    }


}