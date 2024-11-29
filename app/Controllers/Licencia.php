<?php

namespace App\Controllers;

use App\Models\LicenciaModel;
use App\Models\DepartamentoModel;
use App\Models\EmpleadoModel;

class Licencia extends BaseController{

    protected $departamentoModel;
    protected $licenciaModel;
    protected $empleadoModel;

    public function __construct(){

        $this->departamentoModel = new DepartamentoModel();
        $this->licenciaModel = new LicenciaModel();
        $this->empleadoModel = new EmpleadoModel();
    }

    public function index(){

        $lista = $this->licenciaModel->obtenerLicencias();

        return view('licencia/index', ['licencias'=>$lista]);
    }
    public function show(){

        $lista = $this->licenciaModel->obtenerLicencias();

        return view('licencia/show', ['licencias'=>$lista]);
    }

    public function new(){
        $empleados = $this->empleadoModel->obtenerEmpleados();
        $valoresLicencias = $this->valoresTipoLicencias();
        $data = [
            'empleados' => $empleados,
            'valoresLicencias' => $valoresLicencias,
        ];

        return view('licencia/new', $data);
    }

   protected function valoresTipoLicencias(){
       return ['maternal', 'paternal', 'personal', 'duelo', 'vacacional', 'otro'];
   }

   protected function obtenerNombreEmpleado($id){
       $empleado = $this->empleadoModel->devolverEmpleado($id);
       return $empleado['nombre'];
   }

    public function create(){

        if ($this->request->getMethod() ==='POST') {
            
            $data =[
                'empleado_id'=> $this->request->getPost('empleado_id'),
                'tipo'=> $this->request->getPost('tipo'),
                'fecha_inicio'=> $this->request->getPost('fecha_inicio'),
                'fecha_final'=> $this->request->getPost('fecha_final'),
            ];

            try {
                
                $this->licenciaModel->insert($data);
                $nombreEmpleado = $this->obtenerNombreEmpleado($data['empleado_id']);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $nombreEmpleado, $this->licenciaModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'licencia creada exitosamente.',
                    'redirect' => base_url('public/licencia/new') // Redirige a la vista de la tabla
                ]);

            } catch (\Exception $e) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear la licencia: ' . $e->getMessage()
                ]);

            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar la licencia.'
        ]);
    }

    public function edit($id){

        $empleados = $this->empleadoModel->obtenerEmpleados();
        $valores = $this->valoresTipoLicencias();
        $licencia = $this->licenciaModel->devolverlicencia($id);

        if (!$licencia) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('licencia no encontrado con ID: ' . $id);
        }

        $data = [
            'empleados' => $empleados,
            'valoresLicencias' => $valores,
            'licencia'=>$licencia
        ];
        return view('licencia/edit', $data);

    }

    protected function notificarEstado($estado, $estadoAnterior, $empleado){

        if ($estado==="rechazada" && $estadoAnterior!=="rechazada") {
            $mensaje = "Se ha rechazado la licencia del empleado: $empleado ";
            $this->notificacionModel->insertarNotificacion($this->licenciaModel->table, $mensaje);

        }
        
        if ($estado==="aprobada" && $estadoAnterior!=="aprobada") {
            $mensaje = "Se ha aprobado la licencia del empleado: $empleado ";
            $this->notificacionModel->insertarNotificacion($this->licenciaModel->table, $mensaje);

        }
    }

    public function update(){

        $id = $this->request->getPost('id');

        $estado_anterior = $this->request->getPost('estado_anterior');

        $data =[
            'empleado_id'=> $this->request->getPost('empleado_id'),
            'tipo'=> $this->request->getPost('tipo'),
            'fecha_inicio'=> $this->request->getPost('fecha_inicio'),
            'fecha_final'=> $this->request->getPost('fecha_final'),
            'estado'=> $this->request->getPost('estado'),
        ];

        try {
            if ($id) {
                // Actualizar registro existente
                $this->licenciaModel->update($id, $data);
                $nombreEmpleado = $this->obtenerNombreEmpleado($data['empleado_id']);
                $this->historialModel->registrarAccion("actualizacion", $this->nombreUsuario, $nombreEmpleado, $this->licenciaModel->table );
                $this->notificarEstado($data['estado'], $estado_anterior, $nombreEmpleado);

                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'update', 
                    'message' => 'licencia actualizado correctamente.',
                    'redirect' => base_url('public/licencia/') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->licenciaModel->insert($data);
                $response = ['status' => 'success', 'message' => 'licencia creado exitosamente.'];
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
            $licencia = $this->licenciaModel->devolverLicencia($id);
            $nombreEmpleado = $this->obtenerNombreEmpleado($licencia['empleado_id']);
            
            if ($this->licenciaModel->delete($id)) {
                $view = null;
                $this->historialModel->registrarAccion("eliminacion", $this->nombreUsuario, $nombreEmpleado, $this->licenciaModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'licencia eliminado exitosamente.',
                    'vista' =>'licencia'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar la licencia.'
                ]);
            }
        }
    }


}