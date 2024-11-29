<?php

namespace App\Controllers;

use App\Models\NominaModel;
use App\Models\SalarioModel;
use App\Models\EmpleadoModel;
use Dompdf\Dompdf;
use Dompdf\Options;


class Nomina extends BaseController{

    protected $salarioModel;
    protected $nominaModel;
    protected $empleadoModel;

    public function __construct(){

        $this->salarioModel = new SalarioModel();
        $this->nominaModel = new NominaModel();
        $this->empleadoModel = new EmpleadoModel();
    }

    public function index(){

        $lista = $this->nominaModel->obtenerNominas();


        return view('nomina/index', ['nominas'=>$lista]);
    }

    protected function obtenerDatosFacturaNomina($id) {

        $nomina = $this->nominaModel->devolverNomina($id);
        if (!$nomina) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('nomina no encontrado con ID: ' . $id);
        }
        $empleado = $this->empleadoModel->devolverEmpleado($nomina['empleado_id']);
        $empleados = $this->empleadoModel->obtenerEmpleados();

        $salario = $this->salarioModel->devolverSalario($nomina['salario_id']);
        
        // Formatear los datos
        $salario = $this->formatearCifras($salario);
        $nomina['horas_extras_total'] = $this->agregarPuntos($nomina['horas_extras_total']);
        $nomina['nomina_total'] = $this->agregarPuntos($nomina['nomina_total']);
        $nomina['deduccion_ausencia'] = $this->agregarPuntos($nomina['deduccion_ausencia']);
    
        return [
            'empleado' => $empleado,
            'empleados' => $empleados,
            'nomina' => $nomina,
            'salario' => $salario
        ];
    }
    
    public function show($id) {
        $data = $this->obtenerDatosFacturaNomina($id);
        #$data['isPDF'] = true;

        return view('nomina/factura-nomina', $data);
    }
    
    public function generarPDF($id) {
        $data = $this->obtenerDatosFacturaNomina($id);
        $data['isPDF'] = true;
        $nombreEmpleado = $data['empleado']['nombre'];

    
        // Iniciar Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        
        // Crear el contenido HTML para la factura
        $html = view('nomina/factura-nomina', $data);
    
        // Cargar el HTML al objeto Dompdf
        $dompdf->loadHtml($html);
    
        // Configurar el tamaño del papel y la orientación
        $dompdf->setPaper('A4', 'portrait');
    
        // Renderizar el PDF
        $dompdf->render();
    
        // Enviar el PDF al navegador
        $dompdf->stream('factura_nomina_' . $nombreEmpleado . '.pdf', ['Attachment' => false]);
    }
    
    public function new(){
        $empleado = $this->empleadoModel->obtenerEmpleados();

        $data = [
            'empleados' => $empleado,
        ];

        return view('nomina/new', $data);
    }

    protected function obtenerSalario($id){
        
        $salario = $this->salarioModel->devolverSalario($id);
        return $salario;

    }

    protected function obtenerIdEmpleado($id_nomina){

        $nomina = $this->nominaModel->devolverNomina($id_nomina);
        return $nomina['empleado_id'];

    }

    protected function obtenerNombreEmpleado1($id){
        $empleados = $this->empleadoModel->obtenerEmpleados();
        foreach ($empleados as  $empleado) {
            if ($empleado['id_empleado'] === $id) {
                return $empleado;
                
            }
            return null;
        }
    }
   

    public function create(){

        if ($this->request->getMethod() ==='POST') {
            
            $data =[
                'empleado_id'=> $this->request->getPost('empleado_id'),
                'nomina_base'=> $this->request->getPost('nomina_base'),
                'aux_transporte'=> $this->request->getPost('aux_transporte'),
                'bonificacion'=> $this->request->getPost('bonificacion'),
                'encargado_id'=> $this->request->getPost('empleado_id'),
                'deduccion_salud'=> $this->request->getPost('deduccion_salud'),
                'deduccion_pension'=>$this->request->getPost('deduccion_pension'),
                'nomina_total'=>$nominaTotal

            ];

            try {
                $data = $this->obtenerNombreEmpleado($data['empleado_id']);
                $this->nominaModel->insert($data);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $data['nombre'], $this->nominaModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'nomina creada exitosamente.',
                    'redirect' => base_url('public/nomina/new') // Redirige a la vista de la tabla
                ]);

            } catch (\Exception $e) {

                
                

            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar la nomina.'
        ]);
    }

    public function editNomina($id){

        $empleados = $this->empleadoModel->obtenerEmpleados();
        $nomina = $this->nominaModel->devolverNomina($id);

        if (!$nomina) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('nomina no encontrado con ID: ' . $id);
        }

        $data = [
            'empleados' => $empleados,
            'nomina'=>$nomina
        ];

        view('nomina/edit', $data);

    }



    public function update(){

        $id = $this->request->getPost('id');
        $idSalario = $this->request->getPost('idSalario');
        $pagar = $this->request->getPost('pagar');
        $nomina = $this->nominaModel->devolverNomina($id);
        $id_empleado = $nomina['empleado_id'];

        $data =[];

        if (!empty($pagar)) {

           $data = $this->pagarNomina($id);

           if ($data===false) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'error: la Nomina del mes actual esta pagada. Debe esperar el proximo mes '
                ]);
               
           }else{
                $this->notificarNomina($id_empleado);
           }

        } else {

            $data = $this->calcularNomina($idSalario);
            
        }
        

        try {
            if ($id) {
                // Actualizar registro existente
                $this->nominaModel->update($id, $data);
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'update', 
                    'message' => 'nomina actualizada correctamente.',
                    'redirect' => base_url('public/nomina') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->nominaModel->insert($data);
                $response = ['status' => 'success', 'message' => 'nomina creado exitosamente.'];
            }
        } catch (\Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al procesar la solicitud.'];
        }

        return $this->response->setJSON($response);

    }

    function convertirEntero($numero) {
        // Elimina la parte decimal y convierte a entero
        return (int) round($numero);
    }

    public function agregarPuntos($numero) {
        return number_format($numero, 0, ',', '.'); // Formato: 1.234.567
    }

    public function formatearCifras($data) {
        
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

    protected function calcularNomina($id_salario){
        $empleadoSalario = $this->obtenerSalario($id_salario);

        $valor_horas = $this->request->getPost('valor_horas');
        $valor_horas = isset($valor_horas)? $valor_horas : 0 ;
        $cantida_horas_extras = $this->request->getPost('cantidad_horas_extras');
        $cantida_horas_extras = isset($cantida_horas_extras) ? $cantida_horas_extras : 0 ;


        $cantidad_ausencia = $this->request->getPost('cantidad_ausencia');
        $cantidad_ausencia = isset($cantidad_ausencia) ? $cantidad_ausencia : 0 ;
        $salario_base = $this->convertirEntero($empleadoSalario['salario_base']);
        $salario_dia = $salario_base / 30 ;

        $horas_extras_total = $cantida_horas_extras * $valor_horas;
        $deduccion_ausencia = $salario_dia * $cantidad_ausencia ;
        $salario_total = $this->convertirEntero($empleadoSalario['salario_total']);

        $nomina_total = $salario_total + $horas_extras_total - $deduccion_ausencia ;

        return [
            'horas_extras_total' => $horas_extras_total,
            'deduccion_ausencia' => $deduccion_ausencia,
            'nomina_total' => $nomina_total
        ];

    }

    protected function pagarNomina($id) {
        $nomina = $this->nominaModel->devolverNomina($id);
        #$this->generarPDF($id);

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');
        $fechaPagar = date('Y-m-25'); 
        $fechaProxima = date('Y-m-25', strtotime('first day of next month')); 
    
        
        if ($nomina['estado'] === 'pagado' && $nomina['fecha_anterior'] === $fechaPagar) {
            return false; 
        }
    
        
        if ($nomina['estado'] === 'pagado' && $fechaActual > $fechaPagar) {
            return false; 
        }
    
       
        return [
            'fecha_anterior' => $fechaPagar, 
            'fecha_proxima' => $fechaProxima, 
            'estado' => 'pagado'
        ];
    }


    protected function obtenerNombreEmpleado($idEmpleado){
        $empleado = $this->empleadoModel->devolverEmpleado($idEmpleado);
        return $empleado['nombre'];
    }

    protected function notificarNomina($idEmpleado){
        $nombreEmpleado = $this->obtenerNombreEmpleado($idEmpleado);
        $mensaje = "Se ha pagado la nomina del empleado: $nombreEmpleado ";
        $this->notificacionModel->insertarNotificacion($this->nominaModel->table, $mensaje);

    }

    
    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getJSON()->id; // Obtener ID del cuerpo JSON de la solicitud
            
            if ($this->nominaModel->delete($id)) {
                $view = null;
                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'nomina eliminado exitosamente.',
                    'vista' =>'nomina'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar el nomina.'
                ]);
            }
        }
    }


}