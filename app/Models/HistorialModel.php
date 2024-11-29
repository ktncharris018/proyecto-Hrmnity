<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialModel extends Model {
    protected $table = 'Historial';
    protected $primaryKey = 'id_historial';
    protected $allowedFields = ['tipo', 'descripcion', 'fecha', 'tabla'];

   
    public function registrarAccion($tipo, $usuario, $nombreRegistro, $tabla) {
        // Validar el tipo de acción
        if (!in_array($tipo, ['creacion', 'actualizacion', 'eliminacion'])) {
            throw new \InvalidArgumentException('Tipo de acción inválido.');
        }

        // Creacion de la descripción según el tipo de acción
        switch ($tipo) {
            case 'creacion':
                $descripcion = "El usuario $usuario ha creado un nuevo registro $nombreRegistro en $tabla.";
                break;
            case 'actualizacion':
                $descripcion = "El usuario $usuario ha actualizado el registro $nombreRegistro en $tabla.";
                break;
            case 'eliminacion':
                $descripcion = "El usuario $usuario ha eliminado el registro  $nombreRegistro en $tabla.";
                break;
        }

        date_default_timezone_set('America/Bogota');
       
        $data = [
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'fecha' => date('Y-m-d H:i:s'), 
            'tabla' => $tabla
        ];

        return $this->insert($data);
    }

    public function obtenerHistoriales(){
        return $this->findAll();


    }
}
