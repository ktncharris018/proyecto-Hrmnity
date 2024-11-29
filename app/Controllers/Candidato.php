<?php

namespace App\Controllers;

use App\Models\DepartamentoModel;
use App\Models\CandidatoModel;
use App\Models\VacanteModel;
use App\Libraries\FileHandler;

class  Candidato extends BaseController{

    protected $candidatoModel;
    protected $vacanteModel;
    protected $filehandler;

    public function __construct(){

        $this->candidatoModel = new CandidatoModel();
        $this->vacanteModel = new VacanteModel();
        $this->filehandler = new FileHandler();
    
    }

    public function index(){

        $lista = $this->candidatoModel->obtenerCandidatos();

        return view('candidato/index', ['candidatos'=>$lista]);
    }

    public function show(){

        $lista = $this->candidatoModel->obtenerCandidatos();

        return view('candidato/show', ['candidatos'=>$lista]);
    }

    public function new(){
        $vacantes = $this->vacanteModel->obtenerVacantes();

        $data = [
            'vacantes' => $vacantes,
        ];

        return view('candidato/new', $data);
    }

   

    public function create(){

        if ($this->request->getMethod() ==='POST') {

            $portafolio = $this->request->getFile('portafolio');
            $nombrePortaflio = $this->validarPdf();

            if (is_array($nombrePortaflio)) {
               return $this->response->setJSON($nombrePortaflio);        
            }

            $data =[
                'nombre'=> $this->request->getPost('nombre'),
                'identificacion'=> $this->request->getPost('identificacion'),
                'contacto'=> $this->request->getPost('contacto'),
                'estado'=> $this->request->getPost('estado'),
                'fecha_solicitud'=> $this->request->getPost('fecha_solicitud'),
                'vacante_id'=> $this->request->getPost('vacante_id'),
                'portafolio'=> $nombrePortaflio
            ];

            
            try {
                
                $this->candidatoModel->insert($data);
                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $data['nombre'], $this->candidatoModel->table );

                if ($nombrePortaflio!=null) {
                    if (!$this->filehandler->upload('archivos', 'candidatos', $portafolio, $nombrePortaflio)) {
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'El archivo no se almacenó correctamente.'
                        ]);
                    }
                    
                }
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'candidato creado exitosamente.',
                    'redirect' => base_url('public/candidato/new') // Redirige a la vista de la tabla
                ]);

        

            } catch (\Exception $e) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear el candidato: ' .$e->getMessage()
                ]);

            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar el candidato.'
        ]);
    }

    protected function validarPdf()
    {
        $archivoPdf = $this->request->getFile('portafolio');
    
    
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
    
        
        $nombrePdf = 'candidato_' . $this->request->getPost('identificacion') . '.' . $extension;
    
        return $nombrePdf;
    
    }
    

    public function edit($id){

        $vacantes = $this->vacanteModel->obtenerVacantes();
        $candidatos = $this->candidatoModel->devolverCandidato($id);

        if (!$candidatos) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Empleado no encontrado con ID: ' . $id);
        }

        $data = [
            'candidatos' => $candidatos,
            'vacantes'=>$vacantes
        ];
        return view('candidato/edit', $data);

    }

    public function update(){

        $id = $this->request->getPost('id');

        $portafolio = $this->request->getFile('portafolio');
        $nombrePortafolio = $this->validarPdf();

        if (is_array($nombrePortafolio)) {
            return $this->response->setJSON($nombrePortafolio);
        }


        $data =[
            'nombre'=> $this->request->getPost('nombre'),
            'identificacion'=> $this->request->getPost('identificacion'),
            'contacto'=> $this->request->getPost('contacto'),
            'estado'=> $this->request->getPost('estado'),
            'fecha_solicitud'=> $this->request->getPost('fecha_solicitud'),
            'vacante_id'=> $this->request->getPost('vacante_id'),
            'portafolio'=> $nombrePortafolio
        ];

        try {
            if ($id) {
                // Actualizar registro existente
                $this->candidatoModel->update($id, $data);
                $this->historialModel->registrarAccion("actualizacion", $this->nombreUsuario, $data['nombre'], $this->candidatoModel->table );

                if ($nombrePortafolio!=null) {
                    
                    if (!$this->filehandler->upload('archivos', 'candidatos', $portafolio, $nombrePortafolio)) {
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'El archivo no se almacenó correctamente.'
                        ]);
                    }
                }


                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'update', 
                    'message' => 'candidato actualizado correctamente.',
                    'redirect' => base_url('public/candidato/') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->candidatoModel->insert($data);
                $response = ['status' => 'success', 'message' => 'candidato creado exitosamente.'];
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
            $data = $this->candidatoModel->devolverCandidato($id);
            
            if ($this->candidatoModel->delete($id)) {
                $this->historialModel->registrarAccion("eliminacion", $this->nombreUsuario, $data['nombre'], $this->candidatoModel->table );

                $view = null;
                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'candidato eliminado exitosamente.',
                    'table' =>$view
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar el candidato.'
                ]);
            }
        }
    }


}