<?php

namespace pan;


class panFunc {

    private static $tiempo_inicial;
    private static $tiempo_final;

	/**
	 * imprimir en pantalla variable $str
	 * @param  mixed $str 
	 * @param  boolean $die true si se desea terminar la ejecucion del script despues de mostrar la variable
	 * @return [type]      [description]
	 */
	public static function printThis($str,$die=null){
		echo "<pre>";
		if(is_array($str) or is_object($str))
			print_r($str);
		else
			echo $str;

		echo "</pre>";
		if($die){
			die();
		}
	}


    public static function dumpThis($str,$die=null){
        echo "<pre>";
        var_dump($str);
        echo "</pre>";
        if($die){
            die();
        }
    }


    public static function startTime(){
        self::$tiempo_inicial = microtime(true);
    }


    public static function stopTime(){
        self::$tiempo_final = microtime(true) - self::$tiempo_inicial;
    }


    public static function getTimeExecute(){
        return self::$tiempo_final;
    }

}