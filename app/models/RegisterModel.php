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

	public function createPerson($post)
	{
		$this->db->query("CALL spCreatePerson(:firstname, :lastname, :username, :password, :email, :mobile)");
		$this->db->bind(':firstname', $post['firstname'], PDO::PARAM_STR);
		$this->db->bind(':lastname', $post['lastname'], PDO::PARAM_STR);
		$this->db->bind(':username', $post['username'], PDO::PARAM_STR);
		$this->db->bind(':password', password_hash($post['password'], PASSWORD_BCRYPT), PDO::PARAM_STR);
		$this->db->bind(':email', $post['email'], PDO::PARAM_STR);
		$this->db->bind(':mobile', $post['mobile'], PDO::PARAM_STR);
		return $this->db->execute();
	}

	public function findEmail($email)
	{
		$this->db->query("CALL spFindEmail(:email)");
		$this->db->bind(':email', $email, PDO::PARAM_STR);
		return $this->db->single();
	}

	public function findUsername($username)
	{
		$this->db->query("CALL spFindUsername(:username)");
		$this->db->bind(':username', $username, PDO::PARAM_STR);
		return $this->db->single();
	}

	public function findPersonByEmailOrUsername($userString)
	{
		$this->db->query("CALL spFindPersonByEmailOrUsername(:userString)");
		$this->db->bind(":userString", $userString, PDO::PARAM_STR);
		return $this->db->single();
	}
}
