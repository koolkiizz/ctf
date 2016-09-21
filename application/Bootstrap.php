<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoLoader()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Core');
	}

	protected function _initConfig() {
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', 'custom');
		$registry = Zend_Registry::getInstance();
	    $registry->set('Config', $config);
	}

	protected function _initTranslate() {
	    $translate = new Zend_Translate('array', APPLICATION_PATH . "/languages/", null, array('scan' => Zend_Translate::LOCALE_DIRECTORY));
	    $registry = Zend_Registry::getInstance();
	    $registry->set('Zend_Translate', $translate);
	    Zend_Form::setDefaultTranslator($translate);
	    $config = $registry->get("Config");
	    $translate->setLocale($config->language);
	}
	
}

