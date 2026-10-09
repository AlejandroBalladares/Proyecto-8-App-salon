<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicio = Servicio::all();
        echo json_encode($servicio);
    }

    public static function guardar(){
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        echo json_encode($resultado);
    }
}