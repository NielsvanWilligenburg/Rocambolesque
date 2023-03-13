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
		$this->db->query("CALL spCreatePerson(:firstname, :infix, :lastname, :username, :password, :email, :mobile)");
		$this->db->bind(':firstname', $post['firstname'], PDO::PARAM_STR);
		$this->db->bind(':infix', $post['infix'], PDO::PARAM_STR);
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

	public function findPersonById($id)
	{
		$this->db->query("Select per.Firstname, per.Infix, per.Lastname, user.Username, con.Email, con.Mobile from person as per
								inner join contact as con
									on per.Id = con.PersonId
								inner join user
									on per.Id = user.PersonId
	  						where per.Id = :id");
		$this->db->bind(":id", $id, PDO::PARAM_INT);
		return $this->db->single();
	}

	public function updatePerson($post)
	{
		try {
			$this->db->query("update person as per, contact as con, user as user
									set per.Firstname = :firstname,
									per.Infix = :infix,
									per.Lastname = :lastname,
									user.Username = :username,
									con.Email = :email,
									con.mobile = :mobile
								where per.Id = con.PersonId and per.Id = user.PersonId
									and per.Id = :id");
			$this->db->bind(':firstname', $post['firstname'], PDO::PARAM_STR);
			$this->db->bind(':infix', $post['infix'], PDO::PARAM_STR);
			$this->db->bind(':lastname', $post['lastname'], PDO::PARAM_STR);
			$this->db->bind(':username', $post['username'], PDO::PARAM_STR);
			$this->db->bind(':email', $post['email'], PDO::PARAM_STR);
			$this->db->bind(':mobile', $post['phoneNumber'], PDO::PARAM_STR);
			$this->db->bind(':id', $_SESSION['id'], PDO::PARAM_INT);
			// $this->db->bind(':id', 4, PDO::PARAM_INT);
			return $this->db->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function deletePerson($id)
	{
		$this->db->query("call delete_person_and_related_tables(:id)");
		$this->db->bind(':id', $id, PDO::PARAM_INT);
		return $this->db->execute();
	}
}
