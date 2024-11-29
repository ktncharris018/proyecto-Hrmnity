<?php

namespace App\Controllers;

use App\Models\EmpleadoModel;

use App\Models\DepartamentoModel;
use App\Libraries\FileHandler;


class Empleado extends BaseController
{
    protected $empleadoModel;
    protected $departamentoModel;
    protected $filehandler;

    public function __construct()
    {
        $this->empleadoModel = new EmpleadoModel();
        $this->departamentoModel = new DepartamentoModel();
        $this->filehandler = new FileHandler();
    }

    public function index()
    {
       
        #$lista['empleados'] = $this->empleadoModel->obtenerEmpleados();
        $lista = $this->empleadoModel->obtenerEmpleados();
        
        return view('empleado/index', ['empleados'=>$lista]); // Manda los datos a la vista
    }


    public function show($tipo, $categoria, $nombreFile) {
        $ruta = $this->filehandler->getFilePath($tipo, $categoria, $nombreFile);
    
        if (file_exists($ruta)) {
            $ext = pathinfo($ruta, PATHINFO_EXTENSION);
            switch (strtolower($ext)) {
                case 'jpg':
                case 'jpeg':
                    $this->response->setHeader('Content-Type', 'image/jpeg');
                    break;
                case 'png':
                    $this->response->setHeader('Content-Type', 'image/png');
                    break;
                case 'gif':
                    $this->response->setHeader('Content-Type', 'image/gif');
                    break;
                default:
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
    
            // Establecer el tamaño del contenido
            $this->response->setHeader('Content-Length', filesize($ruta));
    
            // Usar el método getFile() para enviar el archivo
            return $this->response->setBody(file_get_contents($ruta));
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    
    public function new(){
        $lista = $this->departamentoModel->obtenerDepartamentos();

        return view('empleado/new', ['departamentos'=>$lista] );
    }
    
    public function createPhp()
    {
        if ($this->request->getMethod() === 'POST') {
            // Validar y procesar la foto
            $nombreFoto = $this->validarFoto();
            
            // Si $nombreFoto es un error de redirección, retornamos el error
            if ($nombreFoto instanceof \CodeIgniter\HTTP\RedirectResponse) {
                return $nombreFoto; // Retorna el error si hay problema con la imagen
            }
    
            try {
                // Intentar insertar el nuevo empleado en la base de datos
                $this->empleadoModel->insert([
                    'nombre' => $this->request->getPost('nombre'),
                    'identificacion' => $this->request->getPost('identificacion'),
                    'contacto' => $this->request->getPost('contacto'),
                    'tipo_contrato' => $this->request->getPost('tipo_contrato'),
                    'supervisor' => $this->request->getPost('supervisor'),
                    'titulo' => $this->request->getPost('titulo'),
                    'departamento_id' => $this->request->getPost('departamento_id'),
                    'foto_perfil' => $nombreFoto
                ]);
    
                return redirect()->to('public/empleado/new')->with('success', 'Empleado creado exitosamente.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                // Manejo de errores específicos de la base de datos
                $errorMessage = $this->manejarExcepcion($e->getMessage());
    
                return redirect()->to('public/empleado/new')->with('error', $errorMessage);
            } catch (\Exception $e) {
                // Captura cualquier otra excepción y redirige con un mensaje de error general
                return redirect()->to('public/empleado/new')->with('error', 'Error al crear el empleado: ' . $e->getMessage());
            }
        }
    
        // Redirige con un mensaje de error si no es una solicitud POST
        return redirect()->to('public/empleado/new')->with('error', 'No se pudo agregar el empleado.');
    }

        public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            // Validar y procesar la foto
            $nombreFoto = $this->validarFoto();

            if ($nombreFoto instanceof \CodeIgniter\HTTP\RedirectResponse) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al procesar la foto: .'.$nombreFoto
                ]);
            }

            $nombreEmpleado = $this->request->getPost('nombre');
            try {
                // Insertar datos
                $this->empleadoModel->insert([
                    'nombre' => $nombreEmpleado,
                    'identificacion' => $this->request->getPost('identificacion'),
                    'contacto' => $this->request->getPost('contacto'),
                    'tipo_contrato' => $this->request->getPost('tipo_contrato'),
                    'supervisor' => $this->request->getPost('supervisor'),
                    'titulo' => $this->request->getPost('titulo'),
                    'departamento_id' => $this->request->getPost('departamento_id'),
                    'foto_perfil' => $nombreFoto
                ]);

                $this->historialModel->registrarAccion("creacion", $this->nombreUsuario, $nombreEmpleado, $this->empleadoModel->table );

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Empleado creado exitosamente.',
                    'vista' =>'empleado',
                    'redirect' => base_url('public/empleado/new') // Redirige a la vista de la tabla
                ]);
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $errorMessage = $this->manejarExcepcion($e->getMessage());
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al crear el empleado: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No se pudo agregar el empleado.'
        ]);
    }

        
        protected function manejarExcepcion($mensaje)
    {
        if (strpos($mensaje, 'Duplicate entry') !== false) {
            return 'El identificador ingresado ya existe. Por favor, use un identificador diferente.';
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


    protected function validarFoto(){
        #return redirect()->back()->with('error', 'estoy en validarfoto()');
        $fotoPerfil = $this->request->getFile('foto_perfil');

        
        // Si no se subió ninguna foto, retornamos null
        if (!$fotoPerfil->isValid()) {
            return null;
        }
        
        // Validar formato de archivo
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $extension = strtolower($fotoPerfil->getExtension());

        if (!in_array($extension, $allowedExtensions)) {
            return redirect()->back()->with('error', 'Formato de imagen no permitido, solo JPG, JPEG, PNG');
        }

        // Validar tamaño de archivo (2MB máximo)
        if ($fotoPerfil->getSize() > 2048 * 1024) { // Tamaño en bytes
            return redirect()->back()->with('error', 'El archivo es demasiado grande. Máximo 2MB.');
        }

        $nombreFoto = 'empleado_' . $this->request->getPost('identificacion') . '.' . $extension;

        if (!$this->filehandler->upload('img', 'empleados', $fotoPerfil, $nombreFoto)) {
            return redirect()->back()->with('error', 'El archivo no se almaceno correctamente.'); 
        }
        #$fotoPerfil->move(WRITEPATH . 'uploads', $nombreFoto);

        return $nombreFoto;
    }

    public function edit($id)
    {
        
        $empleado = $this->empleadoModel->devolverEmpleado($id);
        $departamentos = $this->departamentoModel->obtenerDepartamentos();

        if (!$empleado) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Empleado no encontrado con ID: ' . $id);
        }

        $data = [
            'empleado' => $empleado,
            'departamentos' => $departamentos,
        ];
    
        return view('empleado/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id'); // Suponiendo que el campo ID se llama 'id_empleado'

        $nombreFoto = $this->validarFoto();

        if ($nombreFoto instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al procesar la foto.'
            ]);
        }
        $nombreEmpleado = $this->request->getPost('nombre');
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'identificacion' => $this->request->getPost('identificacion'),
            'contacto' => $this->request->getPost('contacto'),
            'tipo_contrato' => $this->request->getPost('tipo_contrato'),
            'supervisor' => $this->request->getPost('supervisor'),
            'titulo' => $this->request->getPost('titulo'),
            'departamento_id' => $this->request->getPost('departamento_id'),
            'foto_perfil' => $nombreFoto
        ];

        try {
            if ($id) {
                // Actualizar registro existente
                $this->empleadoModel->update($id, $data);
                $this->historialModel->registrarAccion("actualizacion", $this->nombreUsuario, $nombreEmpleado, $this->empleadoModel->table );

                
                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'update', 
                    'message' => 'Empleado actualizado correctamente.',
                    'redirect' => base_url('public/empleado/') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->empleadoModel->insert($data);
                $response = ['status' => 'success', 'message' => 'Empleado creado exitosamente.'];
            }
        } catch (\Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al procesar la solicitud.'];
        }

        return $this->response->setJSON($response);
    }


    public function getTable()
    {
       
        #$lista['empleados'] = $this->empleadoModel->obtenerEmpleados();
        $lista = $this->empleadoModel->obtenerEmpleados();
        
        return view('empleado/tabla', ['empleados'=>$lista]); // Manda los datos a la vista
    }



    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getJSON()->id; // Obtener ID del cuerpo JSON de la solicitud
            $empleado = $this->empleadoModel->devolverEmpleado($id);
            $nombreEmpleado = $empleado['nombre'];
            
            if ($this->empleadoModel->delete($id)) {
                $this->historialModel->registrarAccion("eliminacion", $this->nombreUsuario, $nombreEmpleado, $this->empleadoModel->table );

                $view = $this->getTable();
                return $this->response->setJSON([
                    'status' => 'success',
                    'id'=>$id,
                    'message' => 'Empleado eliminado exitosamente.',
                    'table' =>$view
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al eliminar el empleado.'
                ]);
            }
        }
    }


    

}


