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

    public static function olvide(){
        echo "upsi";
    }

    public static function recuperar(){
        echo "desde recuperar";
    }
    public static function crear_cuenta(){
        echo "desde crear";
    }
}   