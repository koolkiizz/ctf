<?php

class Models_DefaultController extends Zend_Controller_Action
{
    public $db;
    public function init()
    {
        $this->db = $this->dbconnect();
    }
    
    public function dbconnect()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', 'database');
        $database = [
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->dbname
        ];
        try {
            $db = Zend_Db::factory('Pdo_Mysql', $database);
            $db->getConnection();
            return $db;
        } catch(Zend_db_Adapter_Exception $es)
        {
            die("Failed to connect database!");
        }
    }
}