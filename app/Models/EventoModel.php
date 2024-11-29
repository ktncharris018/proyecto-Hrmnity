<?php

namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model{

    protected $table = 'eventos';
    protected $primaryKey ='id';
    protected $allowedFields = ['title', 'start', 'end', 'className'];

    public function obtenerEventos(){

        return $this->findAll();
    }

    public function devolverEvento($id){

        return $this->find($id);
    }


}

?>