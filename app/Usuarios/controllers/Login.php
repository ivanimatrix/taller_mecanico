<?php

/**
 * Module Usuarios
 * Class Login
 */
class Login extends \pan\Controller{

	public function __construct(){
		parent::__construct();
	}


	public function index(){
        \pan\View::addJS('Login.js');
	    \pan\View::render('login/login');
    }


    public function loginUsuario(){

	    $rut = trim(\pan\Request::getParametros('rut'));
	    $pass = trim(\pan\Request::getParametros('pass'));

	    $response = array();

	    if(empty($rut) and empty($pass)){
	        $response['estado'] = false;
	        $response['mensaje'] = 'Datos ingresados no pueden estar vacíos';
        }else{
	        $Usuario = new Usuario();
	        $datos = $Usuario->read('id_usuario, nombres_usuario, apellidos_usuario, perfil_usuario')->conditions(array('rut_usuario' => $rut, 'pass_usuario' => \pan\panHash::passwordHash($pass)))->runQuery()->getRows(0);

	        if($datos){

	            \pan\panSession::setSession('id', $datos->id_usuario);
	            \pan\panSession::setSession('nombres', $datos->nombres_usuario);
	            \pan\panSession::setSession('apellidos', $datos->apellidos_usuario);
	            \pan\panSession::setSession('perfil', $datos->perfil_usuario);

                $response['estado'] = true;
                $response['redirect'] = \pan\Uri::getBaseUri() . '/Home/Dashboard/panel';
            }else{
	            $response['estado'] = false;
	            $response['mensaje'] = 'Los datos ingresados no son correctos. Intente nuevamente';
            }

        }

        header('Content-type:text/json;charset=UTF-8');
        echo json_encode($response);

    }


    public function logoutUsuario(){

        \pan\panSession::sessionKill();

        \pan\Response::redirect(pan\Uri::getBaseUri());
    }


}