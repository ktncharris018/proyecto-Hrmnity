<?php

namespace App\Models;

use CodeIgniter\Model;

class EntrevistaModel extends Model{

    protected $table = 'entrevistas';
    protected $primaryKey ='id_entrevista';
    protected $allowedFields = ['candidato_id','fecha','soportes','estado','observacion'];

    public function obtenerEntrevistas()
    {
        return $this->db->table($this->table)
            ->select('entrevistas.*, candidatos.nombre AS candidato')
            ->join('candidatos', 'candidatos.id_candidato = entrevistas.candidato_id') 
            ->get()
            ->getResultArray();
    }

    public function devolverEntrevista($id){

        return $this->find($id);
    }

    public function getEntrevistasPorEstado()
    {
        $sql = "SELECT DATE_FORMAT(fecha, '%M %Y') AS mes,
        SUM(CASE WHEN estado = 'contratado' THEN 1 ELSE 0 END) AS contratado,
        SUM(CASE WHEN estado = 'seleccionado' THEN 1 ELSE 0 END) AS seleccionado,
        SUM(CASE WHEN estado = 'rechazado' THEN 1 ELSE 0 END) AS rechazado
        FROM entrevistas
        GROUP BY mes
        ORDER BY fecha;";
                
        return $this->db->query($sql)->getResultArray(); // Ejecutar la consulta y retornar el resultado
    }


}

?>