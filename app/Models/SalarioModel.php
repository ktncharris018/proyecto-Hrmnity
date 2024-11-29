<?php

namespace App\Models;

use CodeIgniter\Model;

class SalarioModel extends Model{

    protected $table = 'salarios';
    protected $primaryKey ='id_salario';
    protected $allowedFields = ['empleado_id','salario_base','aux_transporte','bonificacion','deduccion_salud','deduccion_pension','salario_total'];

    public function obtenersalarios()
    {
        return $this->db->table($this->table)
            ->select('salarios.*, empleado.nombre AS empleado')
            ->join('empleado', 'empleado.id_empleado = salarios.empleado_id') 
            ->get()
            ->getResultArray();
    }

    public function devolverSalario($id){

        return $this->find($id);
    }


}

?>