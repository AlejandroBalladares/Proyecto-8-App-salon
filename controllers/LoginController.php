<?php

namespace Controllers;

use MVC\Router;

class loginController{
    public static function login(Router $router){
        $router->render('auth/login');
    }

    public static function logout(){
        echo "chau";
    }

    public static function olvide(Router $router){
        $router->render('auth/olvide', [

        ]);
    }

    public static function recuperar(){
        echo "desde recuperar";
    }
    public static function crear(Router $router){
        $router->render('auth/crear-cuenta', [

        ]);
    }
}   