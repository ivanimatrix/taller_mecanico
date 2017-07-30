<?php
namespace pan;

class Uri
{

    private static $_port;

    public function __construct()
    {
        self::$_port = '';
        if ($_SERVER['SERVER_PORT'] != 80) {
            self::$_port = ':' . $_SERVER['SERVER_PORT'];
        }
    }

    public static function getHost()
    {
        self::$_port = '';
        if ($_SERVER['SERVER_PORT'] != 80) {
            self::$_port = ':' . $_SERVER['SERVER_PORT'];
        }
        $url = $_SERVER['SERVER_NAME'] . self::$_port . $_SERVER['SCRIPT_NAME'];
        $url = explode('/', $url);
        $tmp = array_pop($url);
        $url = implode("/", $url);

        return 'http://' . $url . '/';
        //return $_SERVER['SERVER_NAME'];

    }


    public static function getBaseUri()
    {
        self::$_port = '';
        if ($_SERVER['SERVER_PORT'] != 80) {
            self::$_port = ':' . $_SERVER['SERVER_PORT'];
        }
        $url = $_SERVER['SERVER_NAME'] . self::$_port . $_SERVER['SCRIPT_NAME'];
        return 'http://' . $url;

        /*$url = explode('/',$url);
        $tmp = array_pop($url);
        $url = implode("/",$url);

        return 'http://'.$url;*/

    }
}