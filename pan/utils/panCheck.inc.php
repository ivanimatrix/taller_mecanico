<?php

namespace sys\utils;

use \sys\panError;

class panCheck
{

    /**
     * revisar version de PHP instalada
     */
    private function _checkPHPVersion()
    {
        if (phpversion() < 5)
            panError::_showErrorAndDie('Su versión de PHP debe ser 5 o superior');
    }


    /**
     * revisar extensiones para base de datos
     */
    private function _checkDBEngine()
    {
        /* PDO Extension */
        if (defined('DB_TYPE') and !empty(DB_TYPE)) {
            if (!extension_loaded('PDO')) {
                panError::_showErrorAndDie('Se requiere la extensión PDO para trabajar con base de datos');
            } else {
                if (DB_TYPE === 'mysql' and !extension_loaded('pdo-mysql')) {
                    panError::_showErrorAndDie('Se requiere la extensión pdo-mysql para trabajar con motor MySQL');
                } elseif (DB_TYPE === 'pgsql' and !extension_loaded('pdo-pgsql')) {
                    panError::_showErrorAndDie('Se requiere la extensión pdo-pgsql para trabajar con motor PostgreSQL');
                }
            }
        }
    }


    private function _checkExtension($ext)
    {
        if(!extension_loaded($ext))
            panError::_showErrorAndDie('Se requiere tener instalada la extensión '.$ext);
    }


    public function _checkAll()
    {
        $this->_checkPHPVersion();

        $this->_checkDBEngine();

        $this->_checkExtension('mb_string');
    }
}