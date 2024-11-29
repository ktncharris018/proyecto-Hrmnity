<?php

namespace App\Controllers;
use App\Models\UsuarioModel;


class Usuario extends BaseController
{

    protected $usuarioModel;

    public function __construct(){

        $this->usuarioModel = new UsuarioModel();
    }

    public function getIndex()
    {
        return view('welcome_message');
    }

    public function getShow($id){
        $usuario = $this->usuarioModel->obtenerUsuarioEmpleado($id);

        return view('usuario/perfil', ['usuario'=>$usuario]);
    }

    public function putUpdate(){

        $id = $this->request->getPost('id');
        $contraseña_actual = $this->request->getPost('contraseña_actual');


        $data =[
            'contraseña'=> $this->request->getPost('contraseña_nueva'),
        ];

        ///$usuario = $this->obtenerUsuario($id);


        $mensajeNotificacion = "Se ha modificado la contraseña del usuario con nombre: {$this->nombreUsuario}";

        try {
            if ($this->validarContraseña($contraseña_actual, $id)) {
                // Actualizar registro existente
                $this->usuarioModel->update($id, $data);
                $this->notificacionModel->insertarNotificacion($this->usuarioModel->table, $mensajeNotificacion);
                return $this->response->setJSON([
                    'status' => 'success',
                    'tipo'=>'updateded', 
                    'message' => 'Se ha cambiado la contraseña exitosamente.',
                    'redirectt' => base_url('public/usuario/') // Cambia esta URL a donde quieras redirigir
                ]);

            } else {
                // Crear nuevo registro
                $this->usuarioModel->insert($data);
                $response = ['status' => 'success', 'message' => 'Departamento creado exitosamente.'];
            }
        } catch (\Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al procesar la solicitud.'];
        }

        return $this->response->setJSON($response);

    }

    protected function validarContraseña($contraseña, $id){

        $usuario = $this->obtenerUsuario($id);
        $contraseñaActual = $usuario['contraseña'];

        if ($contraseñaActual===$contraseña) {
            return true;
        }

        return false;
    }

    protected function obtenerUsuario($id){
        $usuario = $this->usuarioModel->devolverUsuario($id);
        return $usuario;

    }

}
