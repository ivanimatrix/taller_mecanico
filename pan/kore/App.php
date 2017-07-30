<?php

namespace pan;


class App
{

    const STATIC_FILES = 'pub/';

    /**
     * nombre de la aplicacion
     * @var string
     */
    private static $app_name;

    /**
     * version de la aplicacion
     * @var mixed
     */
    private static $app_version;

    /**
     * ambiente de ejecucion de la aplicacion
     * @var string
     */
    private static $app_environment;

    /**
     * codificacion de la aplicacion
     * @var string
     */
    private static $app_charset;

    /**
     * pagina a mostrar para error 404 de html
     * @var string
     */
    private static $app_path404;

    /**
     * modulo por defecto
     * @var [type]
     */
    private static $app_default_module;

    /**
     * controlador por defecto
     * @var string
     */
    private static $app_default_controller;

    /**
     * accion por defecto
     * @var [type]
     */
    private static $app_default_action;

    /**
     * template por defecto
     * @var [type]
     */
    private static $app_default_template;

    /**
     * string salt para encriptacion de claves
     * @var [type]
     */
    private static $app_salt = 'thisissaltforencryptation';

    /**
     * habilitar uso de sesiones
     * @var [type]
     */
    private static $app_session;


    /**
     * habilitar uso de log de queries para auditoria
     * @var [type]
     */
    private static $app_db_auditoria;

    /**
     * indicar ambiente de ejecucion para auditoria de queries
     * @var [type]
     */
    private static $app_db_auditoria_environment;


    /**
     * si se activa la auditoria de queries, se debe indicar que parametro de session se debe guardar para asociarlo al usuario que ejecuta la query
     * @var [type]
     */
    private static $app_data_session_user = 'id';


    private static $app_template;


    public function __construct()
    {

    }

    /**
     * setear todas las variables del localismo para la aplicacion
     * @param  [type] $app_locale [description]
     * @return [type]             [description]
     */
    public static function locale($app_locale = 'en_US')
    {
        setlocale(LC_ALL, $app_locale);
    }


    public static function setTimeZone($app_timezone){
        date_default_timezone_set($app_timezone);
    }

    public static function setSessionApp($app_session)
    {
        if (is_bool($app_session))
            self::$app_session = $app_session;
        else
            panError::_showErrorAndDie('El valor para setSessionApp debe ser true o false');

    }


    public static function getSessionApp()
    {
        return self::$app_session;
    }

    /**
     * setear nombre de la aplicacion
     * @param string
     */
    public static function setAppName($app_name)
    {
        self::$app_name = $app_name;
    }

    /**
     * obtener nombre de la aplicacion
     * @return string
     */
    public static function getAppName()
    {
        return self::$app_name;
    }

    /**
     * setear version de la aplicacion
     * @param mixed
     */
    public static function setAppVersion($app_version)
    {
        self::$app_version = $app_version;
    }

    /**
     * obtener version de la aplicacion
     * @return mixed
     */
    public static function getAppVersion()
    {
        return self::$app_version;
    }

    /**
     * setear ambiente de ejecucion de la aplicacion
     * @param string
     */
    public static function setAppEnvironment($app_environment)
    {
        self::$app_environment = $app_environment;
    }

    /**
     * obtener ambiente de ejecucion de la aplicacion
     * @return string
     */
    public static function getAppEnvironment()
    {
        return self::$app_environment;
    }

    /**
     * setear codificacion de la aplicacion
     * @param string
     */
    public static function setCharset($app_charset)
    {
        self::$app_charset = $app_charset;
    }

    /**
     * obtener codificacion de la aplicacion
     * @return string
     */
    public static function getCharset()
    {
        return self::$app_charset;
    }

    /**
     * setear ruta de archivo para pagina 404
     * @param string
     */
    public static function setPath404($app_path404)
    {
        self::$app_path404 = $app_path404;
    }

    /**
     * obtener ruta de archivo de pagina 404
     * @return string
     */
    public static function getPath404()
    {
        return self::$app_path404;
    }


    public static function setDefaultModule($app_default_module)
    {
        self::$app_default_module = $app_default_module;
    }

    public static function getDefaultModule()
    {
        return self::$app_default_module;
    }

    /**
     * setear controlador por defecto para la aplicacion
     * @param string
     */
    public static function setDefaultController($app_default_controller)
    {
        self::$app_default_controller = $app_default_controller;
    }

    /**
     * obtener controlador por defecto de la aplicacion
     * @return string
     */
    public static function getDefaultController()
    {
        return self::$app_default_controller;
    }

    /**
     * setear accion por defecto de la aplicacion
     * @param string
     */
    public static function setDefaultAction($app_default_action)
    {
        self::$app_default_action = $app_default_action;
    }

    /**
     * obtener accion por defecto de la aplicacion
     * @return [type]
     */
    public static function getDefaultAction()
    {
        return self::$app_default_action;
    }

    /**
     * setear template por defecto
     * @param [type] $template [description]
     */
    public static function setDefaultTemplate($template)
    {
        self::$app_default_template = $template;
    }

    /**
     * obtener template por defecto
     * @return [type] [description]
     */
    public static function getDefaultTemplate(){
        return self::$app_default_template;
    }


    public static function setSalt($app_salt)
    {
        self::$app_salt = $app_salt;
    }


    public static function getSalt()
    {
        return self::$app_salt;
    }


    public static function setDbAuditoria($app_db_auditoria = false)
    {
        if (is_bool($app_db_auditoria))
            self::$app_db_auditoria = $app_db_auditoria;
        else
            self::$app_db_auditoria = false;

    }

    public static function getDbAuditoria()
    {
        return self::$app_db_auditoria;
    }


    public static function setDbAuditoriaEnvironment($app_db_auditoria_environment = 'PROD')
    {
        self::$app_db_auditoria_environment;
    }

    public static function getDbAuditoriaEnvironment()
    {
        return self::$app_db_auditoria_environment;
    }


    public static function setDataSessionUser($app_data_session_user = 0)
    {
        self::$app_data_session_user = $app_data_session_user;
    }

    public static function getDataSessionUser()
    {
        return self::$app_data_session_user;
    }

    public static function setTemplate($app_template)
    {
        self::$app_template = $app_template;
    }

    public static function getTemplate()
    {
        return self::$app_template;
    }


}