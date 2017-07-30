<?php
namespace sys;

use sys\db\DbConexion;


class Model {

	protected $db;

	function __construct(){
		$this->db = new DbConexion();
	}

}