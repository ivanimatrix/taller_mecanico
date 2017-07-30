<?php
namespace pan;


class Request
{
    private static $_modulo;
    private static $_controlador;
    private static $_metodo;
    private static $_parametros;

    public function __construct()
    {
        //echo $_SERVER['REQUEST_URI'];die();

        if (isset($_GET['url'])) {
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $url = array_filter($url);

            self::$_controlador = array_shift($url);
            self::$_metodo = array_shift($url);
            self::$_parametros = $url;
        } else {

            if (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false) {
                $url = explode('/index.php', $_SERVER['REQUEST_URI']);
                $query_string = array_pop($url);
                if (empty($query_string)) {
                    self::$_modulo = App::getDefaultModule();
                    self::$_controlador = App::getDefaultController();
                    self::$_metodo = App::getDefaultAction();
                } else {
                    $url = explode("/", trim($query_string, '/'));
                    self::$_modulo = array_shift($url);
                    self::$_controlador = array_shift($url);
                    self::$_metodo = array_shift($url);
                    self::$_parametros = $url;
                }

            } else {
                $url = trim($_SERVER['REQUEST_URI'], "/");
                self::$_modulo = App::getDefaultModule();    
                self::$_controlador = App::getDefaultController();
                self::$_metodo = App::getDefaultAction();
                //self::$_parametros = $url;
            }


        }

        if (!self::$_modulo) {
            self::$_modulo = App::getDefaultModule();
        }

        if (!self::$_controlador) {
            self::$_controlador = App::getDefaultController();
        }

        if (!self::$_metodo) {
            self::$_metodo = App::getDefaultAction();
        }

        if (!isset(self::$_parametros)) {
            self::$_parametros = array();
        }

    }


    public static function getModulo()
    {   
        return self::$_modulo;
    }

    public static function getControlador()
    {
        return self::$_controlador;
    }

    public static function getMetodo()
    {
        return self::$_metodo;
    }

    public static function getParametros($parametro = null)
    {
        if(isset($_REQUEST)){
            foreach($_REQUEST as $request_key => $request_value){
                self::$_parametros[$request_key] = $request_value;
            }
        }
        if($parametro){
            return self::$_parametros[$parametro];    
        }
        return self::$_parametros;
    }

    public static function getFiles($parametro = null){
        if(isset($_FILES)){
            if($parametro){
                return $_FILES[$parametro];
            }else{
                return $_FILES;
            }
        }
        return null;
    }
}


?>