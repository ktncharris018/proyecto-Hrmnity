<?php

namespace App\Models;

use CodeIgniter\Model;

class CandidatoModel extends Model{

    protected $table = 'candidatos';
    protected $primaryKey ='id_candidato';
    protected $allowedFields = ['nombre','identificacion','contacto','estado','fecha_solicitud','vacante_id','portafolio'];

    public function obtenerCandidatos()
    {
        return $this->db->table($this->table)
            ->select('candidatos.*, vacante.nombre AS vacante')
            ->join('vacante', 'vacante.id_vacante = candidatos.vacante_id') 
            ->get()
            ->getResultArray();
    }

    public function devolvercandidato($id){

        return $this->find($id);
    }

    public function getCandidatosPorVacante()
    {
        $sql = "SELECT v.nombre AS vacante, COUNT(c.id_candidato) AS total
                FROM candidatos c
                JOIN vacante v ON c.vacante_id = v.id_vacante
                GROUP BY v.nombre";
                
        return $this->db->query($sql)->getResultArray(); // Ejecutar la consulta y retornar el resultado
    }


}

?>