<?php
namespace pan;


class DbStore {


	private $num_rows;

	private $rows = null;

	private $query_string;


	public function getRows($index=null){
		
		if(is_numeric($index) and $index>=0){
            if(isset($this->rows[$index])){
                return $this->rows[$index];
            }
            return null;
        }
		return $this->rows;
	}


	public function setRows($rows){
		$this->rows = $rows;
	}


	public function getNumRows(){
		return $this->num_rows;
	}


	public function setNumRows($num_rows){
		$this->num_rows = $num_rows;
	}


	public function setQueryString($query_string){
		$this->query_string = $query_string;
	}


	public function getQueryString(){
		return $this->query_string;
	}
}