<?php

class Password extends \pan\Controller{

	public function __construct(){
		parent::__construct();
	}


	public function solicitar(){

	    pan\View::render('password/solicitar_password');
    }
}