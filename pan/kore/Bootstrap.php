<?php
namespace pan;


class Bootstrap
{
    public static function run(Request $_request)
    {

        $module = $_request->getModulo();

        if(!is_dir('app/'.$module)){
            panError::_showErrorAndDie('Módulo <strong>'.$module.'</strong> no encontrado');
        }

        $controller = $_request->getControlador();

        $pathController = 'app' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controller . '.php';
        $method = $_request->getMetodo();
        $parameters = $_request->getParametros();

        if(is_file($pathController)){

            require_once $pathController;

            $controller = new $controller;

            if(is_callable(array($controller, $method))){
                $method = $_request->getMetodo();
            } else {
                if(is_file(App::getPath404())){
                    require_once App::getPath404();
                }else{
                    panError::_showErrorAndDie('Método <strong>'.$method.'</strong> no encontrado');

                }
            }

            if(!empty($parameters)){
                call_user_func_array(array($controller, $method), $parameters);
            } else {
                call_user_func(array($controller, $method));
            }
        } else {
            if(is_file(App::getPath404())){
                require_once App::getPath404();
            }else{
                panError::_showErrorAndDie('Controlador <strong>'.$controller.'</strong> en módulo <strong>'.$module.'</strong> no encontrado');
            }
        }
    }
}


?>