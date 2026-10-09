<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;


class loginController{
    public static function login(Router $router){
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){    
            $auth = new Usuario($_POST);
            //debuguear($auth);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Comprobar que exista el usuario
                /** @var Usuario $usuario */
                $usuario = Usuario::where('email',$auth->email);
                //debuguear($usuario);
                if($usuario){
                    //Verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }
                        else{
                            header('Location: /cita');
                        }

                    };
                }
                else{
                    Usuario::setAlerta('error', 'Mail incorrecto');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas'=>$alertas
        ]);
    }

    public static function logout(){
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){
                /** @var Usuario $usuario */
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //generar un token
                    $usuario->generarToken();
                    $usuario->guardar();
                    //Enviar el mail al usuario
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    Usuario::setAlerta('exito','Revisa tu mail');
                }
                else{
                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                    
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas'=>$alertas,
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //buscar token en la base de datos
        /** @var Usuario $usuario */
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error','Usuario no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if(empty($alertas)){
                //cambiar la contraseña
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = "0";
                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [
            'alertas'=>$alertas,
            'error'=>$error,
        ]);
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