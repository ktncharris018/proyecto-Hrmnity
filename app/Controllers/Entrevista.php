<?php

namespace App\Controllers;

use App\Models\EmpleadoModel;
use App\Models\EntrevistaModel;
use App\Models\CandidatoModel;
use App\Libraries\FileHandler;

class Entrevista extends BaseController{

    protected $entrevistaModel;
    protected $candidatoModel;
    protected $filehandler;
    protected $empleadoModel;

    public function __construct(){

        $this->entrevistaModel = new EntrevistaModel();
        $this->candidatoModel = new CandidatoModel();
        $this->empleadoModel = new EmpleadoModel();
        $this->filehandler = new FileHandler();
    
    }

    public function index(){

        $lista = $this->entrevistaModel->obtenerEntrevistas();

        return view('entrevista/index', ['entrevistas'=>$lista]);
    }

    public function show(){

        $lista = $this->entrevistaModel->obtenerEntrevistas();

        return view('entrevista/show', ['entrevistas'=>$lista]);
    }

    public function new(){
        $entrevista = $this->candidatoModel->obtenerCandidatos();

        $data = [
            'candidatos' => $entrevista,
        ];

        return view('entrevista/new', $data);
    }

   

    public function create(){

        if ($this->request->getMethod() ==='POST') {

            $soporte = $this->request->getFile('soporte');
            $candidato_id = $this->request->getPost('candidato_id');
            $candidato = $this->obtenerCandidato($candidato_id);
            $nombre_candidato = $candidato['nombre'];
            $nombreSoporte = $this->validarPdf($nombre_candidato);

            if (is_array($nombreSoporte)) {
               return $this->response->setJSON($nombreSoporte);        
            }

            $data =[
                'candidato_id'=> $candidato_id,
                'fecha'=> $this->request->getPost('fecha'),
                'estado'=> 'seleccionado',
                'observacion'=> $this->request->getPost('observacion'),
                'soportes'=> $nombreSoporte
            ];

            
            try {
                
                $this->entrevistaModel->insert($data);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $nombre_candidato, $this->entrevistaModel->table );

                if ($nombreSoporte!=null) {
                    if (!$this->filehandler->upload('archivos', 'entrevistas', $soporte, $nombreSoporte)) {
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'El archivo no se almacenó correctamente.'
                        ]);
                    }
                    
                }
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'entrevista creada exitosamente.',
                    'redirect' => base_url('public/candidato/new') // Redirige a la vista de la tabla
                ]);

        

            } catch (\Exception $e) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear la entrevista: ' .$e->getMessage()
                ]);

            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar la entrevista.'
        ]);
    }

    protected function obtenerCandidato($id)
    {
        $candidato = $this->candidatoModel->devolverCandidato($id);

        return $candidato;
    }

    protected function validarPdf($tring)
    {
        $archivoPdf = $this->request->getFile('soporte');
        $nombreCandidato = $tring; 
    
    
        if (!$archivoPdf->isValid()) {
            return null;
        }
        
        // Validar formato de archivo
        $allowedExtensions = ['pdf'];
        $extension = strtolower($archivoPdf->getExtension());
    
        if (!in_array($extension, $allowedExtensions)) {
            return [
                'status' => 'warning',
                'message' => 'Formato de archivo no permitido, solo PDF.'
            ];
        }
    
        // Validar tamaño de archivo (10MB máximo)
        if ($archivoPdf->getSize() > 10 * 1024 * 1024) { // Tamaño en bytes
            return [
                'status' => 'warning',
                'message' => 'El archivo es demasiado grande. Máximo 10MB.'
            ];
        }
    
        
        $nombrePdf = 'entrevista-' . $nombreCandidato . '.' . $extension;
    
        return $nombrePdf;
    
    }

    protected function convertirEnEmpleado($id, $estado){

        $candidato = $this->obtenerCandidato($id);

        if ($estado =="contratado") {
            $dataEmpleado = [
                'nombre' => $candidato['nombre'],
                'identificacion' => $candidato['identificacion'],
                'contacto' => $candidato['contacto'],
                'supervisor'=>'Por definir',
                'titulo'=>'Por definir',
                'departamento_id'=> '14',
                'foto_perfil'=>'avatar-candidato.jpg'
            ];

            try {
                $this->empleadoModel->insert($dataEmpleado);
                return true;
                
                
            } catch (\Exeption $e) {
                $response = ['status' => 'error', 'message' => 'error al convertir en empleado: '.$e->getMessage()];

                return false;
            
            }

        }

        return false;
    }
    

    public function edit($id){

        $candidatos = $this->candidatoModel->obtenerCandidatos();
        $entrevista = $this->entrevistaModel->devolverEntrevista($id);

        if (!$entrevista) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Entrevista no encontrado con ID: ' . $id);
        }

        $data = [
            'entrevista' => $entrevista,
            'candidatos'=>$candidatos
        ];
        return view('entrevista/edit', $data);

    }

    public function update(){

        $id = $this->request->getPost('id');
        $soporte = $this->request->getFile('soporte');
        $candidato_id = $this->request->getPost('candidato_id');
        $candidato = $this->obtenerCandidato($candidato_id);
        $nombre_candidato = $candidato['nombre'];
        $nombreSoporte = $this->validarPdf($nombre_candidato);

        if (is_array($nombreSoporte)) {
            return $this->response->setJSON($nombreSoporte);
        }


        $data =[
            
            'candidato_id'=> $candidato_id,
            'fecha'=> $this->request->getPost('fecha'),
            'estado'=> $this->request->getPost('estado'),
            'observacion'=> $this->request->getPost('observacion'),
            'soportes'=> $nombreSoporte,
        ];

        try {
            if ($id) {
                // Actualizar registro existente
                $this->entrevistaModel->update($id, $data);
                $this->historialModel->registrarAccion("actualizacion", $this->nombreUsuario, $nombre_candidato, $this->entrevistaModel->table );

                if ($nombreSoporte!=null) {
                    
                    if (!$this->filehandler->upload('archivos', 'entrevistas', $soporte, $nombreSoporte)) {
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'El archivo no se almacenó correctamente.'
                        ]);
                    }
                }

                $esEmpleado = $this->convertirEnEmpleado($data['candidato_id'], $data['estado']);
                if ($esEmpleado==true) {
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'tipo'=>'update', 
                        'message' => 'Entrevista actualizada y candidato convertido en empleado exitosamente',
                        'redirect' => base_url('public/entrevista/') // Cambia esta URL a donde quieras redirigir
                    ]);

                } else {
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'tipo'=>'update', 
                        'message' => 'Entrevista actualizada correctamente',
                        'redirect' => base_url('public/entrevista/') // Cambia esta URL a donde quieras redirigir
                    ]);
                }
                
                 
            } else {
                // Crear nuevo registro
                $this->entrevistaModel->insert($data);
                $response = ['status' => 'success', 'message' => 'entrevista creada exitosamente.'];
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
            $data = $this->obtenerCandidato($id);
            
            if ($this->entrevistaModel->delete($id)) {
                $this->historialModel->registrarAccion("eliminacion", $this->nombreUsuario, $data['nombre'], $this->entrevistaModel->table );

                $view = null;
                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'entrevista eliminada exitosamente.',
                    'vista' =>'entrevista'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar la entrevista.'
                ]);
            }
        }
    }


}