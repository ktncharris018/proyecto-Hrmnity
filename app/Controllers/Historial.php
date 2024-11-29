<?php

namespace App\Controllers;


class Historial extends BaseController {
    public function __construct(){

    }

    public function getIndex(){
        $historiales = $this->historialModel->obtenerHistoriales();
        return view('historial/index', ['historiales' => $historiales]);
    }

} 