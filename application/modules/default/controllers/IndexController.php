<?php

class Default_IndexController extends Core_Controller
{
    protected $language;
    protected $config;
    public function init()
    {
        /* Initialize action controller here */
        $this->language = $this->get_language();
        //die(var_dump($this->language));
        $this->view->headers = $this->get_header($this->language->_("Home_page"));
        $this->view->bg = 1;
        /* get config ini */
        $this->config = $this->get_config();
        
    }

    public function indexAction()
    {
        // action body
        $this->view->header_main_title = $this->config->site_name;
    }


}

