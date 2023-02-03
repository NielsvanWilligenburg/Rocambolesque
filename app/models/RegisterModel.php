<?php

class RegisterModel
{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getExample()
	{
		$this->db->query('SELECT * FROM example');

		return $this->db->resultSet();
	}
}
