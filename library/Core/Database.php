<?php

class Core_Database
{
    public function init()
    {

    }
	public function connect()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', 'custom');
        $database = [
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->dbname
        ];
        //debug 4
        // print_r($database);
        // die();
        try {
            $db = Zend_Db::factory('Pdo_Mysql', $database);
            $db->getConnection();
            //debug 5
            //die("Database Connection is ok!");
            return $db;
        } catch(Zend_db_Adapter_Exception $es)
        {
            die("Failed to connect database!");
        }
    }
    

}

