<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionModel extends Model
{
    protected $table      = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    protected $allowedFields = ['titulo', 'descripcion'];

    public function insertarNotificacion($titulo, $descripcion)
    {
        $data = [
            'titulo' => $titulo,
            'descripcion' => $descripcion
        ];

        return $this->insert($data); 
    }

    public function obtenerNotificaciones(){
        return $this->findAll();
    }
}
