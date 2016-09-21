<?php

class Core_UserHandle
{
	/**
	 *
	 * Get all user information
	 * @param $username, $password (in md5 hash), $id
	 *
	 */
	
	public function get_user($username = null, $password = null, $id = null)
	{
		$db = (new Core_Database())->connect();
		/* id is null, so get user by username and password */
		if($id == null && ($username != null && $password != null))
		{
			$select = $db->select()
			             ->from('users')
		                 ->where('email = ?', $username)
		                 ->orWhere('username = ?', $username)
		                 ->where('password = ?', $password);
			$query = $db->query($select);
		}
		else if($id != null && ($username == null && $password == null))
		{
			$select = $db->select()->from('users')->where('id = ?', $id);
			$query = $db->query($select);
		}
		$result = $query->fetchAll();
		//echo $select->__toString();
		$user = new Core_User();
		if(count($result) > 0)
		{
			$user->id 				= $result[0]['id'];
			$user->email 			= $result[0]['email'];
			$user->password 		= $result[0]['password']; //md5 hash
			$user->username 		= $result[0]['username'];
			$user->last_active 		= $result[0]['last_active'];
			$user->activated 		= $result[0]['activated'];
			$user->ip 				= $result[0]['ip'];
			$user->time_created 	= $result[0]['time_created'];
			$user->competition 		= $result[0]['id_competition'];
			$user->level 			= $result[0]['level'];
			$user->token 			= $result[0]['token'];
			//die(print_r($result));
			return $user;
		}
		else
		{
			return false;
		}
	}

	public function add_User(Core_User $user)
	{
		$insert = array(
			'email' 			=> $user->email,
			'password' 			=> md5($user->password),
			'username' 			=> $user->username,
			'last_active' 		=> $user->last_activate,
			'activated' 		=> $user->activated,
			'ip' 				=> $user->ip,
			'time_created' 		=> $user->time_created,
			'id_competition' 	=> $user->competition,
			'level' 			=> $user->level,
			'token' 			=> $user->token
		);
		//debug 3
		// print_r($insert);
		// var_dump($user);
		// die("debug 3");
		$db = (new Core_Database())->connect();
		//debug 6
		// var_dump($db);
		// die();
		if(($query = $db->insert('users', $insert)))
		{
			return true;
		}
		return false;
		
	}

	public function update_user(Core_User $user, $password = false)
	{
		$update = array(
			'last_active' 		=> $user->last_activate,
			'activated' 		=> $user->activated,
			'ip' 				=> $user->ip,
			'id_competition' 	=> $user->competition,
			'level' 			=> $user->level,
			'last_competition'  => $user->last_competition
		);
		if($password) {
			$update['password'] = md5($user->password);
		}
		$db = (new Core_Database())->connect();
		$db->getProfiler()->setEnabled(true);
		try {
			$n = $db->update('users', $update, 'email = \''.$user->email.'\'');
		}
		catch(Exception $ex) {
			$query = $db->getProfiler()->getLastQueryProfile();
			// Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
			  $q = str_replace('?', '<span style="background-color: yellow">%s</span>', $query->getQuery()); 
			  $q = vsprintf($q, array_map(array($db, 'quote'), $query->getQueryParams())); 
			  print "$q\n";  
			
		}
		finally {
			$db->getProfiler()->setEnabled(false);
		}
		// if($db->update('users', $update, 'email = '.$user->email))
		// {
		// 	return true;
		// }
		// return false;
	}

	public function check_ip($ip, Core_User $user)
	{
		if($user->ip == null) {
			$user->ip = $ip.";";
		}
		else {
			$check = false;
			$ips = explode(';',$user->ip);
			foreach($ips as $a) {
				if($a == $ip) {
					$check = true;
					break;
				}
			}
			if($check) {
				//bo qua
				return;
			}
			else {
				$user->ip .= $ip.";";
			}
		}
		$this->update_user($user);
	}

	public function set_last_active(Core_User $user)
	{
		$user->last_activate = date('Y/m/d H:i:s', strtotime('now'));
		$this->update_user($user);
	}

}

