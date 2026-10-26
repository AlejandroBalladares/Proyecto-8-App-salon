<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        $servicios = Servicio::all();
        $nombre = $_SESSION['nombre'];
        $router->render('servicios/index', [
            'nombre'=>$nombre,
            'servicios'=>$servicios,
        ]);
    }

    public static function crear(Router $router){
        $nombre = $_SESSION['nombre'];
        $servicio = new Servicio;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }

        }
        $router->render('servicios/crear', [
            'nombre'=>$nombre,
            'servicio'=>$servicio,
            'alertas'=>$alertas,
        ]);
    }

    public static function actualizar(Router $router){
        $nombre = $_SESSION['nombre'];
        if(!is_numeric($_GET['id'])) return;
        $servicio = Servicio::find($_GET['id']);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        $router->render('servicios/actualizar', [
            'nombre'=>$nombre,
            'servicio'=>$servicio,
            'alertas'=>$alertas,
        ]);
    }

    public static function eliminar(Router $router){
        $nombre = $_SESSION['nombre'];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        }
        $router->render('servicios/eliminar', [
            'nombre'=>$nombre,
        ]);
    }
}