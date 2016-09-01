<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initLoaderResource()
    {
    	$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
    		'basePath'  => dirname(__FILE__),
    		'namespace' => ''
    	));
    	$resourceLoader->addResourceTypes(array(
    		'model' => array(
    			'namespace' => 'Models',
    			'path'      => 'models'
    		)
    	));
    }

}

