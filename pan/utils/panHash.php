<?php

namespace pan;

class panHash {

	/**
	 * generar string aleatorio para Password
	 * @param  integer $largo [description]
	 * @return [type]         [description]
	 */
	public static function randomPass($largo=10){
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890_";
		
		$longitudCadena = strlen($cadena);

		$pass = "";
		
		$longitudPass = $largo;

		for($i = 1 ; $i <= $longitudPass ; $i++){
			$pos = rand(0,$longitudCadena-1);
			$pass .= substr($cadena,$pos,1);
		}
		return $pass;

	}

	/**
	 * [getSha description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public static function getSha($value){
		return sha1($value);
	}

	/**
	 * [getSha256 description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public static function getSha256($value){
		return hash('sha256', $value);
	}

	/**
	 * [getSha512 description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public static function getSha512($value){
		return hash('sha512', $value);
	}

	/**
	 * Generar hash para password pasado como parametro.
     * Si existe la funcion password_hash, el tipo de encriptacion ocupado sera PASSWORD_BCRYPT (blowfish)
	 * @param  [type] $password [description]
	 * @param  string $encrypt  (opcional) Tipo de encriptación. Por defecto es BLOWFISH. Otros valores aceptados son MD5, SHA256 y SHA512
	 * @return [type]           [description]
	 */
	public static function passwordHash($password, $encrypt = 'SHA512'){

		/*if(function_exists('password_hash')){
			return password_hash($password, PASSWORD_BCRYPT);
		}else{
			if(!function_exists('crypt'))
				\pan\panError::_showErrorAndDie('Se necesita tener instalado la extensión para la función crypt');

			$string_salt = \pan\App::getSalt();
			switch (mb_strtoupper($encrypt)) {
				case 'BLOWFISH':
					$salt = '$2a$07$'.$string_salt.'$';
					break;
				case 'SHA512':
					$salt = '$6$rounds=5000$'.$string_salt.'$';
					break;
				case 'SHA256':
					$salt = '$5$rounds=5000$'.$string_salt.'$';
					break;
				case 'MD5':
					$salt = '$1$'.$string_salt.'$';
					break;
				default:
					$salt = '$2a$07$'.$string_salt.'$';
					break;
			}
			

			return crypt($password, $salt);
		}*/
        $string_salt = \pan\App::getSalt();
        switch (mb_strtoupper($encrypt)) {
            case 'BLOWFISH':
                $salt = '$2a$07$'.$string_salt.'$';
                break;
            case 'SHA512':
                $salt = '$6$rounds=5000$'.$string_salt.'$';
                break;
            case 'SHA256':
                $salt = '$5$rounds=5000$'.$string_salt.'$';
                break;
            case 'MD5':
                $salt = '$1$'.$string_salt.'$';
                break;
            default:
                $salt = '$2a$07$'.$string_salt.'$';
                break;
        }


        return crypt($password, $salt);
	}


    /**
     * valida si un password corresponde a su hash generado
     * @param $pass
     * @param $hash
     * @return bool
     */
    public static function validatePass($pass,$hash){
        return password_verify($pass, $hash);
    }


}