<?php
namespace pan;


class Entity{

	protected $db;

	protected $table;

	protected $primary_key;

    protected $_entity = null;

	public function __construct($_entity=null){
        $this->db = new \pan\DbQueryBuilder();
        if(!is_null($_entity)){
            $this->_entity = $_entity;
        }
	}


	public function getPrimaryKey(){
	    return $this->primary_key;
    }

    public function getTable(){
	    return $this->table;
    }

    /**
     * crear una instancia de la entidad para un registro específico
     * @param [type] $_entity [description]
     */
    public function setEntity($_entity){
        $this->_entity = $_entity;
    }


    /**
     * obtener campos de la instancia creada de la entidad
     * @param  string $field nombre del campo que se desea obtener. Si se omite, el retorno correspondera a todos los campos asociados a la entidad instanciada
     * @return [type]        [description]
     */
    public function get($field='*'){
        if(!is_null($this->_entity)){
            $sql = 'select '.$field.' from ' .$this->table .' where ' .$this->primary_key .' = ? ';
            $result = $this->db->getQuery($sql,$this->_entity)->runQuery();
            if($result->getNumRows() > 0){
                if($field == '*' or empty($field) or is_null($field)){
                    return $result->getRows(0);
                }else{
                    return $result->getRows(0)->$field;    
                }
            }
        }
        return null;
    }


	public function create($parametros, $return_last_id = true){

        $insert = "insert into ".$this->table;
        $fields = "";
        $values = "";
        if(is_array($parametros)){
            foreach($parametros as $field => $value){
                $fields .= $field.",";
                $values .= "?,";
                $parameters[] = $value;
            }
            $fields = trim($fields,",");
            $values = trim($values,",");
            $insert .= "(".$fields.") values(".$values.")";
        }


        $return = $this->db->execQuery($insert,$parameters);
        if($return_last_id){
            return $this->db->getLastId();
        }else{
            return $return;
        }
	}


	public function update($parametros, $pk, $conditions=null){
        $parameters = array();
        $update = "update ".$this->table." set ";
        if(is_array($parametros)){
            foreach($parametros as $field => $value){
                $update .= $field ." = ?, ";
                $parameters[] = $value;
            }
            $update = trim($update,", ");
        }

        if(is_null($conditions)){
            $update .= ' where '.$this->primary_key.' = ?';
            $parameters[] = $pk;
        }

        return $this->db->execQuery($update,$parameters);
	}


	public function read($fields="*"){
        $query = "select ";
        if(empty($fields) or is_null($fields))
            $fields = '*';
        

        if(is_null($fields)){
            $fields = '*';
        }else{
            if(\pan\panValidate::isArray($fields)){
                foreach($fields as $field){
                    $query .= $field.', ';
                }
                $query = trim($query,', ');
            }elseif(\pan\panValidate::isLiteral($fields)){
                $query .= $fields.' ';
            }
        }

        $query .= ' from '. $this->table;
        return $this->db->getQuery($query);
	}


	public function delete($parametros, $conditions=null){
        $parameters = array();
        $delete = "delete from ".$this->table. " where ";
        if(is_array($parametros)){
            foreach($parametros as $field => $value){
                $delete .= $field ." = ? AND ";
                $parameters[] = $value;
            }
            $delete = trim($delete,"AND ");
        }

        /*if(is_null($conditions)){
            $update .= ' where '.$this->primary_key.' = ?';
            $parameters[] = $pk;
        }*/

        return $this->db->execQuery($delete,$parameters);
	}

    /**
     * @param $pk_other_table nombre de campo PK en tabla relacionada
     * @param $name_other_table nombre de tabla relacionada
     * @param $fk nombre de campo interno que se relaciona con otra tabla
     * @param $mandatoria valor booleano para indicar si la relacion es obligatoria(TRUE) o no
     * @return $this
     */
    public function hasOneToOne($pk_other_table,$name_other_table,$fk,$mandatoria=false){

        if(!is_null($this->_entity)){
            $sql = 'SELECT a.* from ' .$name_other_table. ' a ';
            if($mandatoria){
                $sql .= ' inner join ' . $this->table . ' b on a.' . $pk_other_table . ' = b.' . $fk;
            }else{
                $sql .= ' left join ' . $this->table . ' b on a.' . $pk_other_table . ' = b.' . $fk;
            }

            $sql .= ' where b.'. $this->primary_key .' = ? ';
            $params = array($this->_entity);
          
            $result = $this->db->getQuery($sql,$params)->runQuery();
        }else{
            $sql = 'select * from ' . $this->table . ' a ';
            
            if($mandatoria){
                $sql .= ' inner join ' . $name_other_table . ' b on a.' . $pk_other_table . ' = b.' . $fk;
            }else{
                $sql .= ' left join ' . $name_other_table . ' b on a.' . $pk_other_table . ' = b.' . $fk;
            }
            
        
            $result = $this->db->getQuery($sql)->runQuery();
        }
        return $result->getRows();
       
    }

    /**
     * @param $pk_other_table nombre de campo PK en tabla relacionada
     * @param $name_other_table nombre de tabla relacionada
     * @param $fk nombre de campo interno que se relaciona con otra tabla
     * @param $mandatoria valor booleano para indicar si la relacion es obligatoria(TRUE) o no
     * @return $this
     */
    public function hasOneToMany($pk_other_table,$name_other_table,$fk,$mandatoria=false){
        return $this->hasOneToOne($pk_other_table,$name_other_table,$fk,$mandatoria);
    }


    /**
     * @param $table_many tabla que se genera de la relacion muchos a muchos
     * @param $arr_entities arreglo con las entidades y campo que se relaciona en $table_many. Ej.: array('Entidad A'=>'campoA','Entidad B'=>'campoB')
     * @return $this
     */
    public function hasManyToMany($table_many,$arr_entities){
        $loader = new \pan\Loader();
        $inner = '';
        if(is_array($arr_entities)){
            foreach($arr_entities as $entity => $pk){
                $a = $loader->entity($entity);
                $inner .= ' inner join ' . $a->getTable() . ' on ' . $a->getPrimaryKey() . ' = ' . $pk;

            }
        }

        $sql = 'select * from ' . $table_many . $inner;
        
        if(!is_null($this->_entity)){
            $params = null;
            $sql .= ' where ' .$this->primary_key .' = ? ';
            $params = array($this->_entity);
            return $this->db->getQuery($sql,$params)->runQuery()->getRows();
        }else{
            return $this->db->getQuery($sql);
        }

    }


    /**
     * verifica si existe un registro con un valor para un campo especifico
     * @param  array $arr_field Arreglo de la forma ['campo' => 'valor']
     * @return boolean           Retorna true si existe algun registro con el valor consultado, o false en caso contrario
     */
    public function unique($arr_field){
        if(!is_array($arr_field))
            return null;

        $query = "select count(".key($arr_field).") as total from ".$this->table. " where ".key($arr_field)." = ? ";
        $result = $this->db->getQuery($query,$arr_field[key($arr_field)])->runQuery()->getRows(0)->total;
        if($result == 1){
            return true;
        }else{
            return false;
        }
    }


}