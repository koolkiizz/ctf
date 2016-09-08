<?php

class Default_RegisterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->headers = [
        	'page_title' => 'Đăng ký',
            'custom_css' => 'register.css',
            'custom_js' => '',
        ];
        $this->view->bg = 2;
    }

    public function indexAction()
    {
        // action body
        $this->view->headScript()->appendFile('//www.google.com/recaptcha/api.js'); 
		$this->view->addHelperPath(APPLICATION_PATH . '/../vendor/cgsmith/zf1-recaptcha-2/src/Cgsmith/View/Helper', 'Cgsmith\\View\\Helper\\');
        //form
        $form = new Default_Form_Register();

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
                        if(!$user_handle->get_user($email, $password) && !$user_handle->get_user($username, $password))
                        {
                            $user->email         = $email;
                            $user->username      = $username;
                            $user->password      = md5($password);
                            $user->last_activate = null;
                            $user->activated     = 0;
                            $user->ip            = null;
                            $user->time_created  = strtotime();
                            $user->competition   = null;
                            $user->level         = 1;
                            $user->token         = md5($password);
                            if($user_handle->add_User($user)) {
                                $this->view->successful = "Successfull!";
                            }
                            else {
                                $this->view->message = "Something was wrong!";
                            }
                        }
            			
                    }
                    else {
                        $this->view->message = "Password doesn't match!";
                    }
        		}
        		else {
        			$this->view->message = "Invail Email!";
        		}
	        	
	        }
        }
 
		$this->view->form = $form;
    }

    protected function token_generate() 
    {

    }
}
