<?php

class IndexController extends Zend_Controller_Action
{
    
    protected $headers;
    public function init()
    {
        /* Initialize action controller here */
        $this->headers = [
            'page_title' => '',
            'custom_css' => '',
            'custom_js' => '',
        ];
        
    }
    
    protected function dbconnect()
    {
        $database = array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'zend'
        );
        try {
            $db = Zend_Db::factory('Pdo_Mysql', $database);
            $db->getConnection();
            return $db;
        } catch(Zend_db_Adapter_Exception $es)
        {
            die("Failed to connect database!");
        }
    }

    public function indexAction()
    {
        //initializing for header
        $this->headers = [
            'page_title' => 'Sample page',
            'custom_css' => ['style.css','footer.css'],
            'custom_js' => '',
        ];
        $this->view->headers = $this->headers;
        $form = new Zend_Form();
        $form->addAttribs(array('role'=>'form', 'action'=>'', 'method'=>'post'));
        $form->addElement('text', 'username');
        $usernameEle = $form->getElement('username');
        $usernameEle->setLabel('Username: ');
        $usernameEle->setAttrib('class', 'form-control');
        $form->addElement('password', 'password');
        $passwordEle = $form->getElement('password');
        $passwordEle->setLabel('Password: ');
        $passwordEle->setAttrib('class', 'form-control');
        $form->addElement('submit','login');
        $submitEle = $form->getElement('login');
        $submitEle->setLabel('Login');
        $submitEle->setAttribs(array('class' => 'btn btn-primary'));
        $this->view->form = $form;
        //process form submit
        if(isset($_POST['login']))
        {
            if($form->isValid($_POST))
            {
                $username = $usernameEle->getValue();
                $password = $passwordEle->getValue();
                if($username != '' && $password != '')
                {
                    $db = $this->dbconnect();
                    $count = $db->fetchOne("Select count(*) from account where username='{$username}' and password='{$password}'");
                    if($count > 0)
                    {
                        $this->view->success = "success";
                    }
                    else
                    {
                        $this->view->errors = 'Fail!';
                    }
                }
                else
                {
                    $this->view->errors = 'Found empty value!';
                }
            }
            else
            {
                $this->view->errors = $form->getMessages();
            }
        }
    }


}

