<?php

namespace App\Controllers;

use App\Models\VacanteModel;
use App\Models\DepartamentoModel;
use App\Models\EmpleadoModel;

class Vacante extends BaseController{

    protected $departamentoModel;
    protected $vacanteModel;
    protected $empleadoModel;

    public function __construct(){

        $this->departamentoModel = new DepartamentoModel();
        $this->vacanteModel = new VacanteModel();
        $this->empleadoModel = new EmpleadoModel();
    }

    public function index(){

        $lista = $this->vacanteModel->obtenerVacantes();

        return view('vacante/index', ['vacantes'=>$lista]);
    }
    public function show(){

        $lista = $this->vacanteModel->obtenerVacantes();

        return view('vacante/show', ['vacantes'=>$lista]);
    }

    public function new(){
        $empleado = $this->empleadoModel->obtenerEmpleados();
        $departamentos = $this->departamentoModel->obtenerDepartamentos();

        $data = [
            'empleados' => $empleado,
            'departamentos' => $departamentos,
        ];

        return view('vacante/new', $data);
    }

   

    public function create(){

        if ($this->request->getMethod() ==='POST') {
            
            $data =[
                'nombre'=> $this->request->getPost('nombre'),
                'descripcion'=> $this->request->getPost('descripcion'),
                'titulo_profesional'=> $this->request->getPost('titulo_profesional'),
                'activa'=> $this->request->getPost('activa'),
                'encargado_id'=> $this->request->getPost('empleado_id'),
                'departamento_id'=> $this->request->getPost('departamento_id')
            ];

            try {
                
                $this->vacanteModel->insert($data);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $data['nombre'], $this->vacanteModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'vacante creada exitosamente.',
                    'redirect' => base_url('public/vacante/new') // Redirige a la vista de la tabla
                ]);

            } catch (\Exception $e) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear la vacante: ' . $e->getMessage()
                ]);

            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar la vacante.'
        ]);
    }

    public function edit($id){

        $empleados = $this->empleadoModel->obtenerEmpleados();
        $departamentos = $this->departamentoModel->obtenerDepartamentos();
        $vacante = $this->vacanteModel->devolverVacante($id);

        if (!$vacante) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Empleado no encontrado con ID: ' . $id);
        }

        $data = [
            'empleados' => $empleados,
            'departamentos' => $departamentos,
            'vacante'=>$vacante
        ];
        return view('vacante/edit', $data);

    }

    public function update(){

        $id = $this->request->getPost('id');


        $data =[
            'nombre'=> $this->request->getPost('nombre'),
            'descripcion'=> $this->request->getPost('descripcion'),
            'titulo_profesional'=> $this->request->getPost('titulo_profesional'),
            'activa'=> $this->request->getPost('activa'),
            'encargado_id'=> $this->request->getPost('empleado_id'),
            'departamento_id'=> $this->request->getPost('departamento_id')
        ];

        try {
            if ($id) {
                // Actualizar registro existente
                $this->vacanteModel->update($id, $data);
                $this->historialModel->registrarAccion("actualizacion", $this->nombreUsuario, $data['nombre'], $this->vacanteModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'update', 
                    'message' => 'vacante actualizado correctamente.',
                    'redirect' => base_url('public/vacante/') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->vacanteModel->insert($data);
                $response = ['status' => 'success', 'message' => 'vacante creado exitosamente.'];
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
            $data = $this->vacanteModel->devolverVacante($id);
            
            if ($this->vacanteModel->delete($id)) {
                $view = null;
                $this->historialModel->registrarAccion("eliminacion", $this->nombreUsuario, $data['nombre'], $this->vacanteModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'vacante eliminado exitosamente.',
                    'vista' =>'vacante'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar la vacante.'
                ]);
            }
        }
    }


}