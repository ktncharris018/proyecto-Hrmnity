<?php

namespace App\Controllers;

use App\Models\TareaModel;
use App\Models\TareaEmpleadoModel;
use App\Models\EmpleadoModel;

class Tarea extends BaseController
{
    protected $tareaModel;
    protected $tareaEmpleadoModel;
    protected $empleadoModel;

    public function __construct()
    {
        $this->tareaModel = new TareaModel();
        $this->tareaEmpleadoModel = new TareaEmpleadoModel();
        $this->empleadoModel = new EmpleadoModel(); 
    }

    public function index()
    {
        $tareasConEmpleados = $this->tareaEmpleadoModel->obtenerTareasConEmpleados();

        return view('tarea/index', ['tareas' => $tareasConEmpleados]);
    }

    public function show()
    {
        $tareasConEmpleados = $this->tareaEmpleadoModel->obtenerTareasConEmpleados();

        return view('tarea/show', ['tareas' => $tareasConEmpleados]);
    }

    public function new(){
        $empleados = $this->empleadoModel->obtenerEmpleados();
        $valoresProgreso = $this->valoresProgreosTarea();
        $data = [
            'empleados' => $empleados,
            'progresoTarea' => $valoresProgreso,
        ];

        return view('tarea/new', $data);
    }

   protected function valoresProgreosTarea(){
       return ['0', '25', '50', '75', '100'];
   }

   protected function insertarEmpleadoTarea($id_tarea, $empleados){
       foreach ($empleados as $empleado) {
           if ($id_tarea) {
               $this->tareaEmpleadoModel->asignarEmpleadoATarea($id_tarea, $empleado);
           }
       }
   }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion'),
                'progreso' => $this->request->getPost('progreso')
            ];

            $empleados = $this->request->getPost('empleados');

            try {
               $idTarea = $this->tareaModel->insert($data);
                // obtener el id reciennte de la tarea
                $this->insertarEmpleadoTarea($idTarea, $empleados);

                $mensajeNotificacion = "Se ha creado una nueva tarea con nombre {$data['nombre']}";

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Tarea creada exitosamente.',
                    'redirect' => base_url('public/tarea') 
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear la tarea: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar la tarea.'
        ]);
    }

    public function edit($id)
    {
        $tarea = $this->tareaModel->devolverTarea($id);
        $empleadoSelected = $this->tareaEmpleadoModel->obtenerEmpleadoPorTarea($id);
        $empleados = $this->empleadoModel->obtenerEmpleados();
        $valoresProgreso = $this->valoresProgreosTarea();




        if (!$tarea) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tarea no encontrada con ID: ' . $id);
        }

        $data = [
            'empleadoSelected' => $empleadoSelected,
            'empleadosList' => $empleados,
            'tarea' => $tarea,
            'progresoTarea' => $valoresProgreso,

        ];
        return view('tarea/edit', $data);
    }

    public function actualizarEmpleadosDeTarea($tarea_id, $empleadosSeleccionados)
{
    // Obtener los empleados asignados actualmente a la tarea
    $empleadosActuales = $this->tareaEmpleadoModel->obtenerEmpleadoPorTarea($tarea_id);

    // Convertir el array de empleados actuales a un array simple con solo los IDs
    $empleadosActualesIds = array_map(function($empleado) {
        return $empleado['id_empleado']; // Asumimos que $empleado es un array con la clave 'id_empleado'
    }, $empleadosActuales);

    // 1. Eliminar empleados que ya no están seleccionados
    $empleadosAEliminar = array_diff($empleadosActualesIds, $empleadosSeleccionados);
    if (!empty($empleadosAEliminar)) {
        $this->tareaEmpleadoModel->eliminarEmpleadosDeTarea($tarea_id, $empleadosAEliminar);
    }

    // 2. Agregar nuevos empleados que no estaban asignados
    $empleadosANuevos = array_diff($empleadosSeleccionados, $empleadosActualesIds);
    foreach ($empleadosANuevos as $empleadoId) {
        // Llamamos al método asignarEmpleadoATarea para agregar cada nuevo empleado
        $this->tareaEmpleadoModel->asignarEmpleadoATarea($tarea_id, $empleadoId);
    }
}


    public function update()
    {
        $id = $this->request->getPost('id');
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => $this->request->getPost('estado'),
            'progreso' => $this->request->getPost('progreso')
        ];

        $empleadosSeleccionados = $this->request->getPost('empleados');

        try {
            if ($id) {
                $this->tareaModel->update($id, $data);
                $this->actualizarEmpleadosDeTarea($id, $empleadosSeleccionados);

                $mensajeNotificacion = "Se ha actualizado la tarea con nombre {$data['nombre']}";

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Tarea actualizada correctamente.',
                    'tipo' => 'update',
                    'redirect' => base_url('public/tarea') 
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al actualizar la tarea: ' . $e->getMessage()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo actualizar la tarea.'
        ]);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getJSON()->id;

            try {
                $tarea = $this->tareaModel->devolverTarea($id);

                if ($this->tareaModel->delete($id)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'id' => $id,
                        'vista' => 'tarea',
                        'message' => 'Tarea eliminada exitosamente.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Error al eliminar la tarea.'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
                ]);
            }
        }
    }
}
