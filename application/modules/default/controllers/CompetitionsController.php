<?php
class Default_CompetitionsController extends Core_Controller
{
	protected $language, $config;
	public function init()
	{
		$this->language = $this->get_language();
		$this->view->headers = $this->get_header($this->language->_("Competitions_page"), 'competitions.css');
		$this->view->bg = 2;
		$this->view->language = $this->language;
	}

	public function indexAction()
	{
		parent::init();
        $competitions = new Core_Competitions();
        $this->view->competitions = $competitions->getAll();
	}

	public function joinAction() {
		parent::init();
		$id_competition = $this->getParam('id');
		if($id_competition && $this->view->isLogin) {
			$competition = (new Core_Competitions())->getOne($id_competition);
			if(strtotime($competition['time_end']) > strtotime('now'))
			{
				$user_competitions = $user->competition;
				$explode = explode(';', $user_competitions);
				$check = true;
				foreach($explode as $a) {
					if($id_competition == $a) {
						$check = false;
						break;
					}
				}
				if($check) {
					$user->competition .= $id_competition.';';
					$user->last_competition = $id_competition;
					$user_handle = new Core_UserHandle();
					$user_handle->update_user($user);
					$this->view->success = "Success";
				}
				else {
					$this->view->message = "Already joined!";
				}
			}
			else {
				$this->view->message = "Competition has finished!";
			}
		}
		else {
			$this->_redirect(BASE_URL);
		}
	}
}