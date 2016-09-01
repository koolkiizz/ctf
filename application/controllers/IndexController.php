<?php
//require_once 'DefaultController.php';
class IndexController extends Models_DefaultController
{
    
    protected $headers;
    public function init()
    {
        parent::init();
        /* Initialize action controller here */
        $this->headers = [
            'page_title' => '',
            'custom_css' => '',
            'custom_js' => '',
        ];
        
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
        
    }


}

