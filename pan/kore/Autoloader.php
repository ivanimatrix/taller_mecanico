<?php
namespace pan;

const DS = DIRECTORY_SEPARATOR;

require_once __DIR__ . '/../../app/app_database.php';
require_once __DIR__ . '/App.php';
require_once __DIR__ . '/../utils/panSession.php';
require_once __DIR__ . '/../utils/panError.php';
require_once __DIR__ . '/../uri/Uri.php';
require_once __DIR__ . '/../db/DbStore.php';
require_once __DIR__ . '/../db/DbConexion.php';
require_once __DIR__ . '/../db/DbQueryBuilder.php';
require_once __DIR__ . '/../utils/panFunc.php';
require_once __DIR__ . '/../utils/panValidate.php';
require_once __DIR__ . '/../utils/panHash.php';
require_once __DIR__ . '/../utils/panFiles.php';
require_once __DIR__ . '/../utils/panJson.php';
require_once __DIR__ . '/../utils/panMinify.php';
require_once __DIR__ . '/Loader.php';
require_once __DIR__ . '/Entity.php';
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/View.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Bootstrap.php';

class Autoloader
{

    private static $directories = array(
        'controllers',
        'entities',
        'libraries'
    );


    static public function loader($className)
    {
        $class = explode('\\',$className);
        $className = end($class);
        foreach (self::$directories as $dir) {
            if (is_dir('app' . DS . \pan\Request::getModulo() . DS . $dir) and is_file('app' . DS . \pan\Request::getModulo() . DS . $dir . DS . $className . '.php')) {
                require_once 'app' . DS . \pan\Request::getModulo() . DS . $dir . DS . $className . '.php';
            }

        }
        
        if (is_dir('libs') and is_file('libs' . DS . $className . '.php')) {
            require_once 'libs' . DS . $className . '.php';
        }
    }
}

spl_autoload_register('\pan\Autoloader::loader');






