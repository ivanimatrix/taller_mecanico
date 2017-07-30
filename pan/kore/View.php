<?php
namespace pan;

class View
{

    static private $data = array();
    static private $dir_views = 'views';
    static private $js_code = '';
    static private $css_code = '';


    /**
     * Renderiza una vista(template)
     * @param null $template string Nombre del fichero de la vista. Si no se especifica, se toma fichero declarado por defecto en App::setDefaultTemplate()
     * @param null $arr_data array Arreglo de datos que seran procesados para ser utilizados en la vista a renderizar
     * @throws \Exception
     */
    public static function render($template = null, $arr_data = null)
    {
        if(!empty($template) or !is_null($template)){
            if(!preg_match('/\.php/i',$template)){
                $template .= '.php';
            }

            $_template = 'app' . DIRECTORY_SEPARATOR . \pan\Request::getModulo() . DIRECTORY_SEPARATOR . self::$dir_views . DIRECTORY_SEPARATOR . $template;
            if (!is_file($_template))
                throw new \Exception('vista no encontrada');

            if (!is_null($arr_data) and is_array($arr_data)) {
                if (count(self::$data) == 0) {
                    self::$data = $arr_data;
                } else {
                    foreach ($arr_data as $k => $v) {
                        self::set($k, $v);
                    }
                }
            }    
        }else{
            if(!empty(\pan\App::getDefaultTemplate())){
                $_template = \pan\App::getDefaultTemplate();
            }else{
                throw new \Exception('No se ha definido un template por defecto. ');                
            }
        }
        

        if (is_array(self::$data) and count(self::$data) > 0)
            extract(self::$data);

        require_once $_template;

        echo self::$js_code;
    }

    /**
     * Procesar una vista para obtener su contenido
     * @param $template
     * @param null $arr_data
     * @param null $other_module
     * @return string
     */
    public static function process($template, $arr_data = null, $other_module = null)
    {
        ob_start();

        if (!is_null($arr_data) and is_array($arr_data)) {
            if (count(self::$data) == 0) {
                self::$data = $arr_data;
            } else {
                foreach ($arr_data as $k => $v) {
                    self::set($k, $v);
                }
            }
        }

        if (is_array(self::$data) and count(self::$data) > 0)
            extract(self::$data);

        if(!preg_match('/\.php/i',$template)){
            $template .= '.php';
        }

        if(!is_null($other_module)){
            $_template = 'app' . DIRECTORY_SEPARATOR . $other_module . DIRECTORY_SEPARATOR . self::$dir_views . DIRECTORY_SEPARATOR . $template;
        }else{
            $_template = 'app' . DIRECTORY_SEPARATOR . \pan\Request::getModulo() . DIRECTORY_SEPARATOR . self::$dir_views . DIRECTORY_SEPARATOR . $template;
        }
        //$_template = 'app' . DIRECTORY_SEPARATOR . \pan\Request::getModulo() . DIRECTORY_SEPARATOR . self::$dir_views . DIRECTORY_SEPARATOR . $template;

        require_once $_template;

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }


    /**
     * Asignar un valor a una variable para la vista
     * @param $name string Nombre de la variable en la vista
     * @param $val mixed Valor que $name debe tener en la vista
     */
    public static function set($name, $val)
    {
        //$this->data[$name] = $val;
        self::$data[$name] = $val;
    }


    /**
     * Agrega codigo CSS a la vista
     * @param $css
     */
    public static function addCSS($css)
    {
        if (!filter_var($css, FILTER_VALIDATE_URL) === false) {
            echo '<link type="text/css" href="'.$css.'" rel="stylesheet"/>';
        }else{
            if (is_file("app/".\pan\Request::getModulo()."/assets/css/".$css) and is_readable("app/".\pan\Request::getModulo()."/assets/css/".$css)) {
                $css_content = file_get_contents("app/".\pan\Request::getModulo()."/assets/css/".$css);
                if (defined('ENVIRONMENT') and ENVIRONMENT == 'PROD') {
                    $css = str_replace('.css', '.min.css', $css);
                }

                $css_content = preg_replace("/[\n|\r|\n\r]/i","",$css_content);
                $ccs_content = \pan\panMinify::minCSS($css_content);
                //echo '<link href="' . \pan\Uri::getHost() . $css . '?'.sha1($css.uniqid()).'" type="text/css" rel="stylesheets" />';
            } else {
                $css_content = $css;
            }
            echo '<style type="text/css">' . $css_content . '</style>';
        }

    }

    /**
     * Agrega codigo Javascript a la vista
     * @param $javascript
     * @param null $dir
     */
    public static function addJS($javascript,$dir = null)
    {

        if (!filter_var($javascript, FILTER_VALIDATE_URL) === false) {
            self::$js_code .= '<script type="text/javascript" src="'.$javascript.'" charset="' . \pan\App::getCharset() . '"></script>';
        } else {
            if($dir == 'pub'){
                if (is_file("pub/js/".$javascript) and is_readable("pub/js/".$javascript)) {
                    $js_content = file_get_contents("pub/js/".$javascript);
                    if (defined('ENVIRONMENT') and ENVIRONMENT == 'PROD') {
                        $javascript = str_replace('.js', '.min.js', $javascript);
                    }

                    //$js_content = preg_replace("/[\n|\r|\n\r]/i","",$js_content);
                    if(strpos($javascript,'min.js') === false)
                        $js_content = \pan\panMinify::minJS($js_content);
                    //echo '<script src="' . \pan\Uri::getHost() . $javascript . '?'.sha1($javascript.uniqid()).'" type="text/javascript" charset="' . \pan\App::getCharset() . '"></script>';
                    self::$js_code .= '<script type="text/javascript" charset="' . \pan\App::getCharset() . '">'.$js_content.'</script>';
                } else {
                    self::$js_code .= '<script type="text/javascript" charset="' . \pan\App::getCharset() . '">console.log("Archivo '.$javascript.' no se ha cargado");</script>';
                }
            }else{
                if (is_file("app/".\pan\Request::getModulo()."/assets/js/".$javascript) and is_readable("app/".\pan\Request::getModulo()."/assets/js/".$javascript)) {
                    $js_content = file_get_contents("app/".\pan\Request::getModulo()."/assets/js/".$javascript);
                    if (defined('ENVIRONMENT') and ENVIRONMENT == 'PROD') {
                        $javascript = str_replace('.js', '.min.js', $javascript);
                    } else {

                    }

                    //$js_content = preg_replace("/[\n|\r|\n\r]/i","",$js_content);
                    //$js_content = self::minify_js($js_content);
                    $js_content = \pan\panMinify::minJS($js_content);
                    //echo '<script src="' . \pan\Uri::getHost() . $javascript . '?'.sha1($javascript.uniqid()).'" type="text/javascript" charset="' . \pan\App::getCharset() . '"></script>';
                    self::$js_code .= '<script type="text/javascript" charset="' . \pan\App::getCharset() . '">'.$js_content.'</script>';
                } else {
                    self::$js_code .= '<script type="text/javascript" charset="' . \pan\App::getCharset() . '">' . $javascript . ';</script>';
                }
            }
        }

    }

}