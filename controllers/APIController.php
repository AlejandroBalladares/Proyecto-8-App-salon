<?php

namespace Controllers;

use Model\Servicio;

class APIController{
    public static function index(){
        $servicio = Servicio::all();
        echo json_encode($servicio);
    }

    public static function guardar(){
        $respuesta = [
            'mensaje' => 'Todo ok'
        ];
        echo json_encode($respuesta);
    }
}