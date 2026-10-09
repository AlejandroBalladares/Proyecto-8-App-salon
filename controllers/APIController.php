<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicio = Servicio::all();
        echo json_encode($servicio);
    }

    public static function guardar(){

        //Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];
        
        //Almacena la cita y el/los servicios
        $idServicios = explode(",", $_POST['servicios']);
        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        //Retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }
}