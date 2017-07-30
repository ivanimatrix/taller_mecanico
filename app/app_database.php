<?php

/**
 * app_database.php
 *
 * Fichero para credenciales a conexion de base de datos
 * 
 */


/**
 * DB_TYPE : Tipo de conexion
 * - MYSQL > para motor MySQL
 * - PGSQL > para motor PostgreSQL
 * - MSSQL > para motor SQL Server
 */
define('DB_TYPE', 'MYSQL');

/** host o IP servidor base de datos */
define('DB_HOST', 'localhost');

/** puerto de conexion */
define('DB_PORT', '3306');

/** schema definido */
define('DB_SCHEMA', '');

/** nombre base de datos */
define('DB_NAME', 'taller_db');

/** usuario de conexion  */
define('DB_USER', 'taller_user');

/** password de conexion */
define('DB_PASS', 'taller_pass');

define('DB_CHARSET', 'utf8');

define('DB_COLLATE', '');

define('DB_PREFIX', '');


/**
 * credenciales para auditoria de queries. Validas cuando App::setDbAuditoria(true)
 * De no definirse alguna de estas constantes, se tomará el valor definido para credenciales de la aplicación
 */
define('DB_TYPE_AUDIT', '');

define('DB_HOST_AUDIT', '');

define('DB_PORT_AUDIT', '');

define('DB_SCHEMA_AUDIT', '');

define('DB_NAME_AUDIT', '');

define('DB_USER_AUDIT', '');

define('DB_PASS_AUDIT', '');

define('DB_CHARSET_AUDIT', '');

define('DB_COLLATE_AUDIT', '');

define('DB_PREFIX_AUDIT', '');
