<?php

namespace App\Models;

use CodeIgniter\Model;

class TareaModel extends Model
{
    protected $table = 'tareas';

    protected $primaryKey = 'id_tarea';

    protected $allowedFields = ['nombre', 'descripcion', 'estado', 'progreso'];

    protected $useTimestamps = false;

    public function obtenerTareas()
    {
        return $this->findAll();
    }

    public function devolverTarea($id)
    {
        return $this->find($id);
    }

    public function getTotalTareasActivas()
    {
        $query = $this->db->query('
            SELECT COUNT(*) AS total_tareas
            FROM tareas
        ');

        return $query->getRow()->total_tareas;
    }
}
