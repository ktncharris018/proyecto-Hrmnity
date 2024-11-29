<?php

namespace App\Controllers;

use App\Models\SalarioModel;
use App\Models\NominaModel;
use App\Models\EmpleadoModel;

class Salario extends BaseController{

    protected $nominaModel;
    protected $salarioModel;
    protected $empleadoModel;

    public function __construct(){

        $this->nominaModel = new NominaModel();
        $this->salarioModel = new SalarioModel();
        $this->empleadoModel = new EmpleadoModel();
    }

    public function index(){

        $lista = $this->salarioModel->obtenerSalarios();

        foreach ($lista as &$salario) {
            $salario = $this->formatearSalarios($salario);
        }

        return view('salario/index', ['salarios'=>$lista]);
    }

    public function show(){

        $lista = $this->salarioModel->obtenersalarios();

        return view('salario/show', ['salarios'=>$lista]);
    }

    public function new(){
        $empleado = $this->empleadoModel->obtenerEmpleados();

        $data = [
            'empleados' => $empleado,
        ];

        return view('salario/new', $data);
    }

    protected function obtenerNombreEmpleado($id){
        $empleado = $this->empleadoModel->devolverEmpleado($id);
        return $empleado['nombre'];
    }

   

    public function create(){

        if ($this->request->getMethod() ==='POST') {
            
            $data =[
                'empleado_id'=> $this->request->getPost('empleado_id'),
                'salario_base'=> $this->request->getPost('salario_base'),
                'aux_transporte'=> $this->request->getPost('aux_transporte'),
                'bonificacion'=> $this->request->getPost('bonificacion'),
                'deduccion_salud'=> $this->request->getPost('deduccion_salud'),
                'deduccion_pension'=>$this->request->getPost('deduccion_pension'),
                'salario_total'=>0

            ];

            $dataSalario = $this->calcularSalario($data);

            try {
                $nombreEmpleado = $this->obtenerNombreEmpleado($data['empleado_id']);
                $id_salario =  $this->salarioModel->insert($dataSalario);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $nombreEmpleado, $this->salarioModel->table );

                #$id_salario = $this->salarioModel->insertID();

                $this->createNomina($dataSalario['empleado_id'], $id_salario, $dataSalario['salario_total']);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $nombreEmpleado, $this->nominaModel->table );


                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'salario creado exitosamente.',
                    'redirect' => base_url('public/salario/new') // Redirige a la vista de la tabla
                ]);

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $erorMensaje = $this->manejarExcepcion($e->getMessage());

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear la salario: ' . $erorMensaje
                ]);

            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar la salario.'
        ]);
    }

    protected function calcularSalario($data) {
        // Definir el porcentaje
        $porcentaje = 0.04;
    
        // Convertir a enteros, asegurando valores por defecto
        $data['salario_base'] = intval($data['salario_base']);
        $data['aux_transporte'] = intval($data['aux_transporte']) ?: 0; // Si es vacío o null, toma 0
        $data['bonificacion'] = intval($data['bonificacion']) ?: 0; // Si es vacío o null, toma 0
        
        // Calcular deducciones si los checkbox están marcados
        $deduccion_salud = isset($data['deduccion_salud']) ? $porcentaje * $data['salario_base'] : 0;
        $deduccion_pension = isset($data['deduccion_pension']) ? $porcentaje * $data['salario_base'] : 0;

        $data['deduccion_salud'] = $deduccion_salud;
        $data['deduccion_pension'] = $deduccion_pension;
    
        // Sumar deducciones
        $total_deducciones = $deduccion_salud + $deduccion_pension;
    
        // Calcular salario total
        $data['salario_total'] = $data['salario_base'] + $data['aux_transporte'] + $data['bonificacion'] - $total_deducciones;
    
        // Devolver la data modificada
        return $data;
    }
    
    public function agregarPuntos($numero) {
        return number_format($numero, 0, ',', '.'); // Formato: 1.234.567
    }

    public function formatearSalarios($data) {
        
        // Lista de campos que deseas formatear
        $camposAFormatear = ['salario_base', 'aux_transporte', 'bonificacion', 'deduccion_salud', 'deduccion_pension', 'salario_total'];
    
        // Modificar los campos deseados usando foreach
        foreach ($camposAFormatear as $campo) {
            if (isset($data[$campo])) {
                $data[$campo] = $this->agregarPuntos($data[$campo]);
            }
        }
    
        // Retornar la data modificada
        return $data;
    }
    

    protected function createNomina($idEmpleado, $idSalario ,$salarioTotal){
       
        $fechaDia25 = date('Y-m-25');

        $dataNomina = [
            'salario_id' => $idSalario,
            'empleado_id' => $idEmpleado,
            'fecha_anterior' => '0000-00-00',
            'fecha_proxima' => $fechaDia25,
            'estado' => 'pendiente',
            'horas_extras_total' => 0,
            'deduccion_ausencia' => 0,
            'nomina_total' => $salarioTotal

        ];

        $this->nominaModel->insert($dataNomina);

    }
    protected function manejarExcepcion($mensaje)
    {
        if (strpos($mensaje, 'Duplicate entry') !== false) {
            return 'El empleado ingresado ya tiene creado un salario. Por favor, use otro empleado diferente.';
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


    public function edit($id){

        $empleados = $this->empleadoModel->obtenerEmpleados();
        $salario = $this->salarioModel->devolverSalario($id);

        if (!$salario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Salario no encontrado con ID: ' . $id);
        }

        $salario = $this->formatearSalarios($salario);

        $data = [
            'empleados' => $empleados,

            'salario'=>$salario
        ];
        return view('salario/edit', $data);

    }

    public function update(){

        $id = $this->request->getPost('id');


        $data =[
            'empleado_id'=> $this->request->getPost('empleado_id'),
            'salario_base'=> $this->request->getPost('salario_base'),
            'aux_transporte'=> $this->request->getPost('aux_transporte'),
            'bonificacion'=> $this->request->getPost('bonificacion'),
            'deduccion_salud'=> $this->request->getPost('deduccion_salud'),
            'deduccion_pension'=>$this->request->getPost('deduccion_pension'),
            'salario_total'=>0
        ];

        $dataSalario = $this->calcularSalario($data);
        $nombreEmpleado = $this->obtenerNombreEmpleado($data['empleado_id']);


        try {
            if ($id) {
                // Actualizar registro existente
                $this->salarioModel->update($id, $dataSalario);
                $this->historialModel->registrarAccion("actualizacion", $this->nombreUsuario, $nombreEmpleado, $this->salarioModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'update', 
                    'message' => 'salario actualizado correctamente.',
                    'redirect' => base_url('public/salario/') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->salarioModel->insert($data);
                $response = ['status' => 'success', 'message' => 'salario creado exitosamente.'];
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
            
            if ($this->salarioModel->delete($id)) {
                $view = null;
                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'salario eliminado exitosamente.',
                    'vista' =>'salario'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar el salario.'
                ]);
            }
        }
    }


}