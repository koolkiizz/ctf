<?php

class IndexController extends Core_Controller
{

    public function init()
    {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction()
    {
        // action body
        $this->view->page_title = $this->language->_("Home_page");
    }


}

