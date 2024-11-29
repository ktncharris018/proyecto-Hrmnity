<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Login extends BaseController {

    protected $usuarioModel;
    protected $usuarioLogin;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        $this->session = session();
        #$this->validarIniciarSesion();
    }

    public function getIndex() {
        return view('login/index'); // Carga la vista de inicio de sesión
    }

    public function postIniciarSesion() {

        if ($this->request->getMethod() === 'POST') {

            $nombreUsuario = $this->request->getPost('usuario');
            $contraseña = $this->request->getPost('contraseña');

            $mensajeValidacion = $this->validarCamposVacios($nombreUsuario, $contraseña);

            if (!empty($mensajeValidacion)) {
                return $this->response->setJSON($mensajeValidacion);

            }


            $this->usuarioLogin = $this->usuarioModel->buscarUsuarioLogin($nombreUsuario);
            #$this->usuarioLogin = $this->usuarioLogin['0'];
            
            $mensajeValidacion2 = $this->validarCampos($contraseña);

            if (!empty($mensajeValidacion2)) {
                return $this->response->setJSON($mensajeValidacion2);

            }

            if ($this->usuarioLogin['estado'] !== 'activo') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Este usuario esta inactivo en el sistema.'
                ]);
                
            }

            // Iniciar sesión
            $this->session->set([
                'usuario_id' => $this->usuarioLogin['id_usuario'],
                'nombre' => $this->usuarioLogin['empleado'],
                'login' => true,
                'foto_perfil' => $this->usuarioLogin['foto_perfil'],
                'ultima_actividad' => time() // Establecer la última actividad al momento del login
            ]);


            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Login exitoso.',
                'tipo' => 'login',
                'redirect' => base_url('public/dashboard') // redirige a 'eventos' o a la ruta deseada
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Error al enviar los datos del Login.'
        ]);
    }

    public function getCerrarSesion() {
        echo "estoy en el metodo cerrarSesion";
        $this->session->destroy(); // Cierra la sesión
        return redirect()->to('public/login'); // Redirige a la página de login
    }

    protected function validarCampos($contraseña){
        #print_r($this->usuarioLogin);
        #print_r($this->usuarioLogin['0']);
        #var_dump($this->usuarioLogin);
         #exit;       

        
        if (!$this->usuarioLogin) {
            return [
                'status' => 'error',
                'message' => 'Usuario incorecto.'
            ];
            
        }

        if ( $contraseña !== $this->usuarioLogin['contraseña']) {
            return [
                'status' => 'error',
                'message' => 'Contraseña incorrecta.'
            ];
        }

            /*         if (!password_verify($contraseña, $this->usuarioLogin['contraseña']) && $usuario !== $this->usuarioLogin['0']['usuario'] ) {
                        return [
                            'status' => 'error',
                            'message' => 'Usuario y Contraseña incorrecta.'
                        ];
                        
                    }
            */
    }

    protected function validarCamposVacios($usuario, $contraseña){
        
        if (empty($usuario) || empty($contraseña)) {
            return [
                'status' => 'error',
                'message' => 'Por favor complete todos los campos.'
            ];
        }

    }

    // protected function validarIniciarSesion(){
    //     if (!$this->session->get('login') || empty($this->sesion)) {
    //         $login = base_url('public/empleado');
    //         // Redirigir a la página de login si no está logueado
    //         return redirect()->to('public/login')->with('error', 'Por favor inicie sesión para acceder a esta página.');
    //     }
    // }

}
