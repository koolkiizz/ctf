<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->headers = [
        	'page_title' => 'Trang chủ',
            'custom_css' => '',
            'custom_js' => '',
        ];
        $this->view->bg = 1;
    }

    public function indexAction()
    {
        // action body
    }


}

