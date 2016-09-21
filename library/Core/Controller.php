<?php
class Core_Controller extends Zend_Controller_Action
{
	public function init()
	{
		if($user = $this->check_login()) {
            $this->view->user = $user;
            $this->view->isLogin = true;
            $explode = explode(';',$user->competition);
            $competition = new Core_Competitions();
            $competition_by_id = array();
            foreach($explode as $a) {
            	if($a) {
            		$competition_by_id[$a] = $competition->getOne($a);
            	}
            }
            $this->view->competition = $competition_by_id;
        }
        else {
            $this->view->isLogin = false;
        }
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
		$config = Zend_Registry::get("Config");
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
			'site_name'          => $config->site_name,
			'custom_css'         => $custom_css,
			'custom_js'          => $custom_js,
			'page_title'         => $page_title,
			'menu_home'          => $language->_("Menu_home"),
			'menu_about'         => $language->_("Menu_about"),
			'menu_competitions'  => $language->_("Menu_competitions"),
			'menu_register'      => $language->_("Menu_register"),
			'menu_login'         => $language->_("Menu_login"),
			'menu_profile'       => $language->_("Menu_profile"),
			'menu_competition'   => $language->_("Menu_competition"),
			'menu_logout'        => $language->_("Menu_logout"),
			);
		return $headers;
	}

	public function check_login()
	{
		$session_auth = new Zend_Session_Namespace('authentication');
		if(isset($session_auth->user) && isset($session_auth->password))
		{
			$user_handle = new Core_UserHandle();
			if($user = $user_handle->get_user($session_auth->user,$session_auth->password))
			{
				return $user;
			}
			else
			{
				return false;
			}
		}
	}
}