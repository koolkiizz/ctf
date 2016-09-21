<?php

class Default_LoginController extends Core_Controller
{
	protected $language, $config;
    public function init()
    {
        /* Initialize action controller here */
        $this->language = $this->get_language();
        $this->view->headers = $this->get_header($this->language->_("Login_page"), 'login.css');
        $this->view->bg = 2;
    }

    public function indexAction()
    {
        // action body
        if($this->check_login()) {  
            // $this->view->message = $this->language->_("Register_page_logged");
            // $this->view->message .= "<br><a href='".BASE_URL."'>".$this->language->_("Register_page_logged")."</a>";
            $this->_redirect(BASE_URL);
            return;
        }
        $this->view->language = $this->language;
        $form = new Default_Form_Login();
        $this->view->form_title = $this->language->_("Login_page_form_title");
        //post handle
        if($this->getRequest()->isPost())
        {
        	if($form->isValid($_POST))
        	{
        		$values = $form->getValues();
        		$username = $values['username'];
        		$password = $values['password'];
        		$user_handle = new Core_UserHandle();
        		if($user = $user_handle->get_user($username, md5($password)))
        		{
        			$session_auth = new Zend_Session_Namespace("authentication");
        			$session_auth->user = $username;
        			$session_auth->password = md5($password);
        			$session_auth->user_level = $user->level;
                    $ip = $this->getRequest()->getServer('REMOTE_ADDR');
                    //die($ip);
                    $user_handle->check_ip($ip, $user);
                    $user_handle->set_last_active($user);
        			$this->_redirect(BASE_URL);
        		}
        		else
        		{
        			$this->view->message = "Wrong username or password!";
        		}
        	}
        }
        $this->view->form = $form;
    }


}

