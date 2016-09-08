<?php

class Core_UserHandle
{
	public function get_user($username = null, $password = null, $id = null)
	{
		$db = (new Core_Database())->connect();
		/* id is null, so get user by username and password */
		if($id == null && ($username != null && $password != null))
		{
			$sql = "select * from users where (username = ? or email = ?) and password = ?";
			$query = $db->query($sql, array($username, $username, md5($password)));
		}
		else if($id != null && ($username == null && $password == null))
		{
			$sql = "select * from users where id = ?";
			$query = $db->query($sql, array($id));
		}
		$result = $query->fetchAll();
		$user = new Core_User();
		if(count($result) > 0)
		{
			$user->id 				= $result[0]->id;
			$user->email 			= $result[0]->email;
			$user->password 		= $result[0]->password;
			$user->username 		= $result[0]->username;
			$user->last_activate 	= $result[0]->last_activate;
			$user->activated 		= $result[0]->activated;
			$user->ip 				= $result[0]->ip;
			$user->time_created 	= $result[0]->time_created;
			$user->competition 		= $result[0]->id_competition;
			$user->level 			= $result[0]->level;
			$user->token 			= $result[0]->token;
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
			'password' 			=> $user->password,
			'username' 			=> $user->username,
			'last_activate' 	=> $user->last_activate,
			'activated' 		=> $user->activated,
			'ip' 				=> $user->ip,
			'time_created' 		=> $user->time_created,
			'id_competition' 	=> $user->competition,
			'level' 			=> $user->level,
			'token' 			=> $user->token
		);
		$db = (new Core_Database())->connect();
		if($db->insert('users', $insert))
		{
			return true;
		}
		return false;
		
	}

}

