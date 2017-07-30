<?php

namespace pan;


class panJSON {



	/**
	 * Convertir un string json a un arreglo u objeto
	 * @param  string  $_json_to_decode JSON string a convertir
	 * @param  boolean $assoc           si es TRUE, el retorno es un array
	 * @param  integer $depth           Profundidad de recursividad. Por defecto es 512
	 * @param  integer $options         [description]
	 * @return mixed                   Por defecto se retorna un Object, 
	 */
	public static function dec_json($_json_to_decode, $assoc = false, $depth = 512, $options = 0){
		
		$_json_to_decode = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $_json_to_decode);
		    
	    if(version_compare(phpversion(), '5.4.0', '>=')) {
	        $_arr = json_decode($_json_to_decode, $assoc, $depth, $options);
	    }
	    elseif(version_compare(phpversion(), '5.3.0', '>=')) {
	        $_arr = json_decode($_json_to_decode, $assoc, $depth);
	    }
	    else {
	        $_arr = json_decode($_json_to_decode, $assoc);
	    }

	    $_error = json_last_error();
		switch ($this->getJsonError($_error)) {
	        case 'No error':
	            return $_arr;
	        	break;
	        default:
	        	return json_encode(array('panJSON error' => $this->getJsonError($_error)));
	        	break;
	    }
	    return $json;
	}


	/**
	 * Codifica un array a formato json
	 * @param  array  $_json_to_encode array a convertir
	 * @return string                  arreglo en Formato JSON
	 */
	public static function enc_json($_json_to_encode = null){
		if(is_null($_json_to_encode)){
			return json_encode(array('panJSON error' => 'Falta parámetro para realizar al codifificacion'));
		}

		$_arr = json_encode($_json_to_encode);
		$_error = json_last_error();
		switch ($this->getJsonError($_error)) {
	        case 'No error':
	            return $_arr;
	        	break;
	        default:
	        	return json_encode(array('panJSON error' => $this->getJsonError($_error)));
	        	break;
	    }
	}


	/**
	 * Obtener error en conversion
	 * @param  [type] $_error [description]
	 * @return [type]         [description]
	 */
	private function getJsonError($_error){
		if (!function_exists('json_last_error_msg')) {
	        function json_last_error_msg() {
	            $ERRORS = array(
	                JSON_ERROR_NONE => 'No error',
	                JSON_ERROR_DEPTH => 'Excedido tamaño máximo de la pila',
	                JSON_ERROR_STATE_MISMATCH => 'Desbordamiento de buffer o los modos no coinciden',
	                JSON_ERROR_CTRL_CHAR => 'Encontrado carácter de control no esperado',
	                JSON_ERROR_SYNTAX => 'Error de sintaxis, JSON mal formado',
	                JSON_ERROR_UTF8 => 'Caracteres UTF-8 malformados, posiblemente están mal codificados'
	            );

	            if(version_compare(phpversion(), '5.5.0', '>=')){
	            	$ERRORS[JSON_ERROR_RECURSION] = 'Una o más referencias recursivas en el valor a codificar';
	            	$ERRORS[JSON_ERROR_INF_OR_NAN] = 'Uno o más valores NAN o INF en el valor a codificar';
	            	$ERRORS[JSON_ERROR_UNSUPPORTED_TYPE] = 'Se proporcionó un valor de un tipo que no se puede codificar';
	            }

	            return isset($ERRORS[$_error]) ? $ERRORS[$_error] : 'Error desconocido';
	        }
	    }
	}

}
