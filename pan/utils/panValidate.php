<?php
namespace pan;

class panValidate {


	public static function isNumber($val){
        return is_numeric($val);
	}


	public static function isEmail($val){
        return filter_var($val,FILTER_VALIDATE_EMAIL);
	}


	public static function isLiteral($val){
        return is_string($val);
	}


    public static function isArray($val){
        return is_array($val);
    }
	
}

