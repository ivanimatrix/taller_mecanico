<?php
require_once __DIR__.'/app/app_config.php';
require_once __DIR__.'/pan/kore/Autoloader.php';

if(\pan\App::getAppEnvironment() === "PROD" or \pan\App::getAppEnvironment() === "TEST"){
    error_reporting(0);
}else{
    error_reporting(E_ALL);
    ini_set('display_errors','On');
}

try {
    \pan\Bootstrap::run(new \pan\Request);
} catch (\Exception $e) {
    \pan\panError::_showErrorAndDie($e->getMessage());
}