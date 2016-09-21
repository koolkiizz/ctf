<?php
class Default_LogoutController extends Core_Controller
{
	public function init()
	{

	}

	public function indexAction()
	{
		$auth = new Zend_Session_Namespace("authentication");
		$auth->unsetAll();
		$this->_redirect(BASE_URL);
	}
}