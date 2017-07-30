<?php

namespace pan;


class panError
{


    public static function _showErrorAndDie($msg_error = null)
    {
        if (is_null($msg_error))
            $msg_error = 'Mensaje de error no especificado';
        $e = new \Exception();
        $error_view = file_get_contents(__DIR__ . '/error-view.html');
        $error_view = str_replace('__appname__', mb_strtoupper(App::getAppName()) , $error_view);
        $error_view = str_replace('__message__', $msg_error . '<br/>' . self::debugTrace(), $error_view);

        echo $error_view;
        die();
    }

    private static function callStack($stacktrace)
    {
        $error = str_repeat("=", 50) . "<br/>";
        $i = 0;
        foreach ($stacktrace as $node) {
            if($i!=0){
                $error .= "$i. " . basename($node['file']) . ":" . $node['function'] . "(linea " . $node['line'] . ")<br/>";
            }

            $i++;
        }

        return $error;
    }


    private static function debugTrace(){
        ob_start(); 
        debug_print_backtrace(); 
        $trace = ob_get_contents(); 
        ob_end_clean(); 

        // Remove first item from backtrace as it's this function which 
        // is redundant. 
        $trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1); 

        // Renumber backtrace items. 
        $trace = preg_replace ('/^#(\d+)/m', '\'#\' . ($1 - 1)', $trace); 

        return $trace;
    }


}