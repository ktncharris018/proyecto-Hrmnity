<?php

namespace App\Models;

use CodeIgniter\Model;

class NominaModel extends Model{

    protected $table = 'nominas';
    protected $primaryKey ='id_nomina';
    protected $allowedFields = ['salario_id', 'empleado_id','fecha_anterior','fecha_proxima','estado','horas_extras_total','deduccion_ausencia','nomina_total'];

    public function obtenerNominas()
    {
        return $this->db->table($this->table)
            ->select('nominas.*, empleado.nombre AS empleado')
            ->join('empleado', 'empleado.id_empleado = nominas.empleado_id') 
            ->get()
            ->getResultArray();
    }

    public function devolverNomina($id){

        return $this->find($id);
    }

    public function getNominasPorEstado()
    {
        return $this->db->query("
            SELECT estado, COUNT(*) AS total
            FROM nominas
            GROUP BY estado
        ")->getResultArray();
    }


}

?>