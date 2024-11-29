<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartamentoModel extends Model{

    protected $table = 'departamento';
    protected $primaryKey ='id_departamento';
    protected $allowedFields = ['nombre', 'estado'];

    public function obtenerDepartamentos(){

        return $this->findAll();
    }

    public function devolverDepartamento($id){

        return $this->find($id);
    }

    public function getTotalDepartamentosActivos()
    {
        $query = $this->db->query('
            SELECT COUNT(*) AS total_departamentos
            FROM departamento
            WHERE estado = "activo"
        ');

        return $query->getRow()->total_departamentos;
    }


}

?>
