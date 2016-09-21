<?php
class Core_Competitions
{
	public function init()
	{

	}
	public function getAll()
	{
		$db = (new Core_Database())->connect();
		$select = $db->select()->from('competition');
		$query = $db->query($select);
		return $query->fetchAll();
	}

	public function getOne($id) {
		$db = (new Core_Database)->connect();
		$select = $db->select()->from('competition')->where('id = ?', $id);
		$query = $db->query($select);
		$competition = $query->fetchAll();
		return $competition[0];
	}
}