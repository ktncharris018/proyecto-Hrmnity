<?php

namespace App\Models;

use CodeIgniter\Model;

class LicenciaModel extends Model
{
    protected $table = 'licencias'; 
    protected $primaryKey = 'id_licencia'; 
    protected $allowedFields = ['empleado_id', 'tipo', 'fecha_inicio', 'fecha_final', 'estado'];

    public function obtenerLicencias()
    {
        return $this->db->table($this->table)
            ->select('licencias.*, empleado.nombre AS empleado')
            ->join('empleado', 'empleado.id_empleado = licencias.empleado_id') 
            ->get()
            ->getResultArray();
    }

    
    public function getLicenciasPorFecha()
    {
        return $this->db->query("
        SELECT e.nombre AS empleado, l.fecha_inicio, l.fecha_final
        FROM licencias l
        JOIN empleado e ON l.empleado_id = e.id_empleado

    ")->getResultArray();
    }


    public function getTotalLicenciasActivas()
    {
        $query = $this->db->query('
            SELECT COUNT(*) AS total_licencias
            FROM licencias
            WHERE estado = "aprobada"
        ');

        return $query->getRow()->total_licencias;
    }

    public function devolverLicencia($id){
        return $this->find($id);
    }
}
