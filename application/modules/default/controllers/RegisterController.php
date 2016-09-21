<?php

class Default_RegisterController extends Core_Controller
{

    protected $language, $config;
    public function init()
    {
        /* Initialize action controller here */
        $this->language = $this->get_language();

        $this->view->headers = $this->get_header($this->language->_("Register_page"), 'register.css');
        $this->view->bg = 2;

    }

    public function indexAction()
    {
        // action body
        //check login first
        if($this->check_login()) {  
            // $this->view->message = $this->language->_("Register_page_logged");
            // $this->view->message .= "<br><a href='".BASE_URL."'>".$this->language->_("Register_page_logged")."</a>";
            $this->_redirect(BASE_URL);
            return;
        }
        //register form
        $this->view->headScript()->appendFile('//www.google.com/recaptcha/api.js'); 
		$this->view->addHelperPath(APPLICATION_PATH . '/../vendor/cgsmith/zf1-recaptcha-2/src/Cgsmith/View/Helper', 'Cgsmith\\View\\Helper\\');
        //form
        $this->view->language = $this->language;
        $form = new Default_Form_Register();
        $this->view->form_title = $this->language->_("Register_page_form_title");

        if ($this->getRequest()->isPost()) {
        	if (!$form->isValid($_POST)) {
	            // Failed validation; redisplay form
	        }
	        else {
	        	$values = $form->getValues();
    			unset($values['g-recaptcha-response']);
        		$email = $values['email'];
        		$username = $values['username'];
        		$password = $values['password'];
        		$repassword = $values['repassword'];
        		$email_validator = new Zend_Validate_EmailAddress(
        			array(
				        'allow' => Zend_Validate_Hostname::ALLOW_DNS,
				        'mx'    => true
				    ));
        		if($email_validator->isValid($email)) {
                    if($password === $repassword) {
                        $user = new Core_User();
                        $user_handle = new Core_UserHandle();
                        //debug 1 
                        //die("input everything is ok!");
                        if(!$user_handle->get_user($email, md5($password)) && !$user_handle->get_user($username, md5($password)))
                        {
                            //debug 2 
                            //die("user is not exist!");
                            $user->email         = $email;
                            $user->username      = $username;
                            $user->password      = $password;
                            $user->last_activate = null;
                            $user->activated     = "0";
                            $user->ip            = null;
                            $user->time_created  = date('Y/m/d H:i:s', strtotime("now"));
                            $user->competition   = null;
                            $user->level         = "1";
                            $user->token         = md5($username);
                            if($user_handle->add_User($user)) {
                                $this->view->successful = $this->language->_("Register_page_form_submit_success");
                            }
                            else {
                                $this->view->message = $this->language->_("Register_page_form_submit_something_wrong");
                            }
                        }
            			else
                        {
                            $this->view->message = $this->language->_("Register_page_form_submit_user_exist");
                        }
                    }
                    else {
                        $this->view->message = $this->language->_("Register_page_form_submit_password_not_match");
                    }
        		}
        		else {
        			$this->view->message = $this->language->_("Register_page_form_submit_invail_email");
        		}
	        	
	        }
        }
 
		$this->view->form = $form;
    }

    protected function token_generate() 
    {

    }
}
