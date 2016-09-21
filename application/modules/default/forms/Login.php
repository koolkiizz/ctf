<?php

class Default_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        /* get language from registry */
        $language = Zend_Registry::get("Zend_Translate");
        /*==============================================
        =            generate login form               =
        ==============================================*/
        
        $frm_username = $this->createElement('text', 'username');
		$frm_username  ->setRequired(true)
		               ->addFilter('StringToLower')
		               ->setAttrib('class', 'form-control')
		               ->setLabel($language->_("Login_page_form_username").':');
		$frm_password = $this->createElement('password', 'password');
		$frm_password  ->addValidator('StringLength', false, array(6))
		               ->setRequired(true)
		         	   ->setAttrib('class', 'form-control')
		               ->setLabel($language->_("Login_page_form_password").':');
		$frm_register = $this->createElement('submit', 'register');
		$frm_register  ->setLabel($language->_("Login_page_form_submit_btn"))
		               ->setAttrib('class', 'button');
		$this->addElement($frm_username)
		     ->addElement($frm_password);
		$this->addElement($frm_register);
        
        /*=====  End of generate login form  ======*/
        
        
    }


}

