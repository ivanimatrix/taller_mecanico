<?php
require_once __DIR__.'/../pan/kore/App.php';


/**
 * Nombre de la aplicacion
 */
\pan\App::setAppName('Taller');

/**
 * Version de la aplicacion
 */
\pan\App::setAppVersion('1.0');

/**
 * Ambiente de ejecucion de la aplicacion
 * - PROD > produccion
 * - TEST > testing
 * - DEV > desarrollo
 * - LOCAL > localhost
 */
\pan\App::setAppEnvironment('DEV');


/**
 * codificacion de la aplicacion
 */
\pan\App::setCharset('');


/**
 * definir pagina para error 404
 */
\pan\App::setPath404('');


\pan\App::setDefaultModule('Usuarios');
/**
 * definir controlador por defecto
 */
\pan\App::setDefaultController('Login');

/**
 * definir pagina por defecto al ingresar
 */
\pan\App::setDefaultAction('index');


/**
 * indicar el template por defecto de la aplicación
 */
\pan\App::setDefaultTemplate('Templates/main_template.php');


/**
 * habilitar uso de sesiones
 */
\pan\App::setSessionApp(true);


/**
 * localizacion de la aplicación
 */
\pan\App::locale('');

\pan\App::setDbAuditoria(false);

\pan\App::setDataSessionUser('');


\pan\App::setTemplate('');



