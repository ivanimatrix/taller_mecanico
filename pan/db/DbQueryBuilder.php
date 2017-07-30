<?php

namespace pan;


class DbQueryBuilder
{

    protected $db;

    protected $table;

    private $string_query;

    private $select;

    private $from;

    private $orderBy;

    private $groupBy;

    private $order;

    private $where;

    private $limit;

    private $join;

    private $result;

    private $num_rows;

    private $query;

    private $params;

    public function __construct()
    {
        $this->db = new \pan\DbConexion();
    }


    public function fields($fields = null)
    {
        if (is_null($fields)) {
            panError::_showErrorAndDie('Se deben ingresar los campos que se desean seleccionar: ' . $this->query);
        }

        if ($this->query === "")
            $this->query = "select ";

        /*if (empty($this->string_query) and panValidate::isLiteral($fields))
            $this->string_query = 'SELECT ' . $fields;*/

        if (panValidate::isArray($fields)) {
            $fields_name = '';
            foreach ($fields as $field) {
                $fields_name .= $field . ', ';
            }
            $fields = trim($fields_name, ', ');

        }
        $this->query = str_replace('*', $fields, $this->query);
        return $this->getQuery($this->query, $this->params);

    }


    public function select($fields = null)
    {

        if ($this->select == "")
            $this->select = "SELECT ";
        
        /*if (empty($this->string_query) and panValidate::isLiteral($fields))
            $this->string_query = 'SELECT ' . $fields;*/

        if (panValidate::isArray($fields)) {
            $fields_name = '';
            foreach ($fields as $field) {
                $fields_name .= $field . ', ';
            }
            $fields = trim($fields_name, ', ');
            $this->select .= $fields . ' ';

        }elseif(is_string($fields)){
            $this->select .= $fields . ' ';
        }else{
            $this->select .= ' * ';
        }
    }


    public function conditions($conditions = null)
    {
        if (!is_null($conditions)) {
            $this->query .= ' where ';
            if (is_array($conditions)) {
                $parameters = array();
                foreach ($conditions as $field => $value) {
                    if(is_array($value)){
                        $this->query .= $field . ' ' . $value[1] . ' ? and ';
                        $parameters[] = $value[0];
                    }else{
                        $this->query .= $field . ' = ? and ';
                        $parameters[] = $value;
                    }
                }
                $this->query = trim($this->query, 'and ');
                $this->params = $parameters;
            } elseif (is_string($conditions)) {
                //$this->query .= ' where ' . $conditions;
                $this->query .= $conditions;
            } elseif (is_numeric($conditions)) {
                $this->query .= $this->primary_key . ' = ?';
            }
        }
        return $this->getQuery($this->query, $this->params);
    }


    public function from($from, $alias = null)
    {
        $this->from = ' FROM ' . $from;
        if (!is_null($alias))
            $this->from .= ' ' . $alias . ' ';
    }


    public function join($table, $conditions, $position = 'LEFT')
    {
        $this->join .= ' ' . $position . ' JOIN ' . $table . ' ' . $conditions;
    }


    public function limit($num_limit, $total = null)
    {
        $total_limit = '';
        if (!is_null($total))
            if (strtolower(DB_TYPE) === 'mysql')
                $total_limit = ',' . $total;
            elseif (strtolower(DB_TYPE) === 'pgsql')
                $total_limit = ' offset ' . $total;

        $this->query .= ' limit ' . $num_limit . $total_limit;
        return $this->getQuery($this->query, $this->params);
    }


    /**
     * Clausula WHERE
     * @param  string $con_logic Conector logico para clausula WHERE: AND|OR
     * @param  array $params    Arreglo con el campo involucrado en clausula WHERE, formato ['campo' => 'valor']
     * @param  string $condition Condicion para la clausula. Por defecto es '='
     */
    public function where($con_logic,$params,$condition = '=')
    {
        if(empty($this->where)){
            $this->where = ' WHERE ';
        }else{
            $this->where = ' ' . strtoupper($con_logic);
        }

        if(is_array($params)){
            $parameters = array();
            foreach ($params as $field => $value) {
                $this->where .= $field . ' ' .$condition. ' ? ';
                $parameters[] = $value;
            }
            
            $this->params = $parameters;
        }


    }


    public function order($by, $order = 'ASC')
    {
        if (panValidate::isArray($by)) {
            $order_query = ' order by ';
            foreach ($by as $key => $value) {
                $order_query .= $key . ' ' . $value . ', ';
            }
            $order_query = trim($order_query, ', ');
            $this->query .= ' ' . $order_query;
        } else {
            $this->query .= ' order by ' . $by . ' ' . $order;
        }

        return $this->getQuery($this->query, $this->params);
    }


    /**
     * ejecutar una sentencia SELECT
     * @param  [string] $query      [setencia SQL a ejecutar]
     * @param  [mixed] $parameters [(opcional) puede ser un array de parametros o un solo parametro]
     * @return [object]             [retorna los resultados de la sentencia como objetos]
     */
    public function getQuery($query, $parameters = null)
    {

        $this->query = $query;
        $this->params = $parameters;

        return $this;
        /*try {
            $stmt = $this->db->prepareQuery($query);
            if (!is_null($parameters)) {
                if (is_array($parameters)) {
                    $stmt->execute($parameters);
                } else {
                    $stmt->execute(array($parameters));
                }
            } else {
                $stmt->execute();
            }
            $this->num_rows = $stmt->rowCount();
            $this->result = $stmt->fetchAll();
            //return $stmt->fetchAll();
            return $this;
        } catch (\PDOException $e) {
            panError::_showErrorAndDie($e->getMessage());
        } catch (\Exception $e) {
            panError::_showErrorAndDie($e->getMessage());
        }*/
    }

    /**
     * ejecutar una sentencia DELETE, UPDATE o INSERT
     * @param  string $query sentencia SQL a ejecutar
     * @param  mixed $parameters (opcional) puede ser un array de parametros, o un solo parametro
     * @return boolean             TRUE si se ejecuto correctamente la sentencia, o de lo contrario retorna NULL
     */
    public function execQuery($query, $parameters = null)
    {
        $this->query = $query;
        $this->params = $parameters;

        try {
            $stmt = $this->db->prepareQuery($query);
            if (!is_null($parameters)) {
                if (is_array($parameters)) {
                    $stmt->execute($parameters);
                } else {
                    $stmt->execute(array($parameters));
                }
            } else {
                $stmt->execute();
            }

            if ($stmt->rowCount() >= 0) {
                return true;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            \pan\panError::_showErrorAndDie($e->getMessage() . "<pre> " . $this->query . "</pre>");
        } catch (\Exception $e) {
            \pan\panError::_showErrorAndDie($e->getMessage());
        }
    }

    /**
     * muestra la query en formato RAW, con parametros incluidos
     * @return [string] [retorna la query formada]
     */
    public function showQuery()
    {
        $keys = array();
        $values = array();

        if (panValidate::isArray($this->params)) {
            foreach ($this->params as $key => $value) {
                if (is_string($key)) {
                    $keys[] = '/:' . $key . '/';
                } else {
                    $keys[] = '/[?]/';
                }

                if (is_numeric($value)) {
                    $values[] = (int)($value);
                } else {
                    $values[] = '"' . $value . '"';
                }
            }
        } else {
            if (is_string($this->params)) {
                $keys[] = '/:' . $this->params . '/';
            } else {
                $keys[] = '/[?]/';
            }

            if (is_numeric($this->params)) {
                $values[] = (int)($this->params);
            } else {
                $values[] = '"' . $this->params . '"';
            }
        }


        $query = preg_replace($keys, $values, $this->query, 1, $count);
        return $query;
    }


    public function runQuery()
    {
        try {
            $store = new \pan\DbStore();

            if(empty($this->query) or is_null($this->query))
                $this->query = $this->select . $this->from . $this->join . $this->where . $this->orderBy . $this->groupBy . $this->limit;
            
            $stmt = $this->db->prepareQuery($this->query);
            $tiempo_inicial = microtime(true);
            if (!is_null($this->params)) {
                if (is_array($this->params)) {
                    $stmt->execute($this->params);
                } else {
                    $stmt->execute(array($this->params));
                }
            } else {
                $stmt->execute();
            }
            $total_time = ((microtime(true) - $tiempo_inicial));

            /*if ($stmt->rowCount() === 1) {
                $this->result = $stmt->fetch();
            }else{
                $this->result = $stmt->fetchAll();    
            }*/
            $this->result = $stmt->fetchAll(); 
            $store->setRows($this->result);
            $store->setNumRows($stmt->rowCount());
            $store->setQueryString($this->showQuery());
            //$this->num_rows = $stmt->rowCount();

            if(\pan\App::getDbAuditoria()){
                $conn_auditoria = new \pan\DbConexion(DB_TYPE_AUDIT, DB_HOST_AUDIT, DB_PORT_AUDIT, DB_NAME_AUDIT, DB_USER_AUDIT, DB_PASS_AUDIT, DB_CHARSET_AUDIT);
                $stmt_auditoria = $conn_auditoria->prepareQuery($this->auditTable());
                $stmt_auditoria->execute();
                $insert_query_log = 'insert into '.DB_PREFIX_AUDIT.'audit_'.date('Ym').'(audit_date,audit_user,audit_query,audit_time,audit_ip) values(?,?,?,?,?)';
                $parameters_log = array(
                    date('Y-m-d H:i:s'),
                    \pan\panSession::getSession(\pan\App::getDataSessionUser()),
                    $this->showQuery(),
                    $total_time,
                    ''
                    );
                $stmt_auditoria = $conn_auditoria->prepareQuery($insert_query_log);
                $stmt_auditoria->execute($parameters_log);
            }

            //return $stmt->fetchAll();
            //
            $this->query = $this->select = $this->from = $this->join = $this->where = $this->orderBy = $this->groupBy = $this->limit = "";
            $this->params = null;

            return $store;
        } catch (\PDOException $e) {
            \pan\panError::_showErrorAndDie($e->getMessage() . "<pre> " . $this->query . "</pre>");
            return null;
        } catch (\Exception $e) {
            \pan\panError::_showErrorAndDie($e->getMessage());
            return null;
        }

    }


    public function getLastId(){
        return $this->db->lastInsertId();
    }


    public function getNumRows()
    {
        return $this->num_rows;
        /*try {
            $stmt = $this->db->prepareQuery($this->query);
            if (!is_null($this->params)) {
                if (is_array($this->params)) {
                    $stmt->execute($this->params);
                } else {
                    $stmt->execute(array($this->params));
                }
            } else {
                $stmt->execute();
            }
            $this->num_rows = $stmt->rowCount();
            return $this->num_rows;
        } catch (\PDOException $e) {
            panError::_showErrorAndDie($e->getMessage());
        } catch (\Exception $e) {
            panError::_showErrorAndDie($e->getMessage());
        }*/

    }


    private function auditTable(){
        /* query para crear o verificar si tabla existe */
        $sufix = date('Ym');
        if(strtolower(DB_TYPE_AUDIT) == 'pgsql'){
            $query = 'CREATE TABLE IF NOT EXISTS '.DB_PREFIX_AUDIT.'audit_'.$sufix.' (
                audit_id serial not null primary key,
                audit_date timestamp without time zone not null,
                audit_user varchar(10) null default 0,
                audit_query text not null,
                audit_time float not null,
                audit_ip varchar(100) null
            );';    
        }elseif(strtolower(DB_TYPE_AUDIT) == 'mysql'){
            $query = 'CREATE TABLE IF NOT EXISTS '.DB_PREFIX_AUDIT.'audit_'.$sufix.' (
                audit_id serial not null primary key,
                audit_date datetime not null,
                audit_user varchar(10) null default 0,
                audit_query text not null,
                audit_time float not null,
                audit_ip varchar(100) null
            ) engine=INNODB default charset='.DB_CHARSET_AUDIT.' collate='.DB_COLLATE_AUDIT.' autoincrement=1;';    
        }

        return $query;

        
    }


}