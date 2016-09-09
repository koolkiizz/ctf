<?php

class Default_Form_Register extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        /* get language from registry */
        $language = Zend_Registry::get("Zend_Translate");
        /**
         *
         * Load Google reCaptcha version 2
         * vendor/cgsmith
         *
         */
        $this->addPrefixPath('Cgsmith\\Form\\Element', APPLICATION_PATH . '/../vendor/cgsmith/zf1-recaptcha-2/src/Cgsmith/Form/Element', Zend_Form::ELEMENT);
 		$this->addElementPrefixPath('Cgsmith\\Validate\\', APPLICATION_PATH . '/../vendor/cgsmith/zf1-recaptcha-2/src/Cgsmith/Validate/', Zend_Form_Element::VALIDATE);
        $this->setMethod('post')->setAction("")->setAttrib('class', 'form-horizontal');
        /*==============================================
        =            generate register form            =
        ==============================================*/
        
        $frm_email = $this->createElement('text', 'email');
        $frm_email     ->setRequired(true)
                       ->setAttrib('class', 'form-control')
                       ->setLabel($language->_("Register_page_form_email").": ");
        $frm_username = $this->createElement('text', 'username');
		$frm_username  ->addValidator('regex', false, array('/^[a-z]+/'))
		               ->addValidator('stringLength', false, array(6, 20))
		               ->setRequired(true)
		               ->addFilter('StringToLower')
		               ->setAttrib('class', 'form-control')
		               ->setLabel($language->_("Register_page_form_username").':');
		$frm_password = $this->createElement('password', 'password');
		$frm_password  ->addValidator('StringLength', false, array(6))
		               ->setRequired(true)
		         	   ->setAttrib('class', 'form-control')
		               ->setLabel($language->_("Register_page_form_password").':');
		$frm_repassword = $this->createElement('password', 'repassword');
		$frm_repassword->addValidator('StringLength', false, array(6))
		               ->setRequired(true)
		               ->setAttrib('class', 'form-control')
		               ->setLabel($language->_("Register_page_form_repassword").':');
		$frm_register = $this->createElement('submit', 'register');
		$frm_register  ->setLabel($language->_("Register_page_form_submit_btn"))
		               ->setAttrib('class', 'button');
		$this->addElement($frm_email)->addElement($frm_username)->addElement($frm_password)->addElement($frm_repassword);
		//get sitekey and secret key in config ini
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', 'custom');
        
		$this->addElement('Recaptcha', 'g-recaptcha-response', [
		    'siteKey'   => $config->recaptcha->sitekey,
		    'secretKey' => $config->recaptcha->secretkey,
		]);
		$this->addElement($frm_register);
        
        /*=====  End of generate register form  ======*/
        
        
    }


}

