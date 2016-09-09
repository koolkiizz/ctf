<?php
class Core_Controller extends Zend_Controller_Action
{
	public function init()
	{
		
	}
	/**
	 *
	 * Setting language to use
	 * @return Zend_Translate object
	 *
	 */
	
	public function get_language()
	{
		// $config = $this->get_config();
		// $translate = new Zend_Translate(
		//     array(
		//         'adapter' => 'array',
		//         'content' => APPLICATION_PATH.'/languages/vi_vn/lang.php',
		//         'locale'  => 'vi'
		//     )
		// );
		// // $translate->addTranslation(
		// //     array(
		// //         'content' => APPLICATION_PATH.'/languages/en_us/lang.php',
		// //         'locale' => 'en'
		// //     )
		// // );
		// // $translate->setLocale($config->language);
		// //Zend_Registry::set('translate', $translate);
  //       return $translate;
		$translate = Zend_Registry::get('Zend_Translate');
		return $translate;
	}

	/**
	 *
	 * Getting config information
	 *
	 */
	

	public function get_config()
	{
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', 'custom');
		return $config;
	}

	/**
	 *
	 * Getting header variables
	 * @param String page_title, array/string custom_css, array/string custom_js
	 * @return array
	 *
	 */
	
	public function get_header($page_title = '', $custom_css = '', $custom_js = '')
	{
		$config = $this->get_config();
		$language = $this->get_language();
		$headers = array(
			'site_name'     => $config->site_name,
			'custom_css'    => $custom_css,
			'custom_js'     => $custom_js,
			'page_title'    => $page_title,
			'menu_home'     => $language->_("Menu_home"),
			'menu_about'    => $language->_("Menu_about"),
			'menu_register' => $language->_("Menu_register"),
			'menu_login'    => $language->_("Menu_login"),
			);
		return $headers;
	}
}