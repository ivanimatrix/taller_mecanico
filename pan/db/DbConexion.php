<?php

namespace pan;

class DbConexion  {

    private $conn;
    private $conn_string = '';
    private $conn_options;
    private $query;
    private $params;

    public function __construct($db_type=DB_TYPE, $db_host=DB_HOST, $db_port=DB_PORT, $db_name=DB_NAME, $db_user=DB_USER,$db_pass=DB_PASS,$db_charset=DB_CHARSET) {

        $this->conn_string = mb_strtolower($db_type) . ':host=' . $db_host . ';port=' . $db_port . ';dbname=' . $db_name;
        $this->conn_options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        );

        if (mb_strtolower($db_type) === 'mysql')
            $this->conn_options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES '" . $db_charset . "'";

        try {
            $this->conn = new \PDO($this->conn_string, $db_user, $db_pass, $this->conn_options);
        } catch (\PDOException $e) {
            panError::_showErrorAndDie($e->getMessage());
        } catch (\Exception $e) {
            panError::_showErrorAndDie($e->getMessage());
        }
    }

    public function prepareQuery($query) {
        return $this->conn->prepare($query);
    }

    public function lastInsertId(){
        return $this->conn->lastInsertId();
    }

}
