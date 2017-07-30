<?php

class Dashboard extends \pan\Controller{

	public function __construct(){
		parent::__construct();
		\pan\panSession::isValidate();
	}


	public function panel(){

    }

}