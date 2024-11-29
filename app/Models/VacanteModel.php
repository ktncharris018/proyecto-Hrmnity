<?php

namespace App\Models;

use CodeIgniter\Model;

class VacanteModel extends Model{

    protected $table = 'vacante';
    protected $primaryKey ='id_vacante';
    protected $allowedFields = ['nombre','descripcion','titulo_profesional','activa','encargado_id','departamento_id'];

    public function obtenerVacantes()
    {
        return $this->db->table($this->table)
            ->select('vacante.*, empleado.nombre AS encargado, departamento.nombre AS departamento')
            ->join('empleado', 'empleado.id_empleado = vacante.encargado_id') 
            ->join('departamento', 'departamento.id_departamento = vacante.departamento_id') 
            ->get()
            ->getResultArray();
    }

    public function devolverVacante($id){

        return $this->find($id);
    }


}

?>