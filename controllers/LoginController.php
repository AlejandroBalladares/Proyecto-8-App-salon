<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
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
        $usuario = new Usuario;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario->sincronizar($_POST);
            //debuguear($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //revisar que aletas este vacio
            if(empty($alertas)){
                //vereficar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                //si está registrado
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }
                //No está registrado
                else{
                    //hashear el password
                    $usuario->hashPassword();

                    //Generar un token unico
                    $usuario->generarToken();

                    //enviar el mail
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }

                }
            }
            
        }
    
        $router->render('auth/crear-cuenta', [
            'usuario'=> $usuario,
            'alertas'=>$alertas,
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];

        $token = s($_GET['token']);
        /** @var Usuario $usuario */
        $usuario = Usuario::where("token", $token);
        //debuguear($usuario);
        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        }
        else{
            //Modificar al usuario
            $usuario->confirmado = "1";
            $usuario->token = "0";
            
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta confirmada correctamente');

        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,

        ]);
        
    }
}   