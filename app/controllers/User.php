<?php

class User extends Controller
{
	private $userModel;

	public function __construct()
	{
		$this->userModel = $this->model('UserModel');
	}

	public function index()
	{
		$data = [
			'title' => 'Example',
			'description' => 'This is the example page'
		];

		$this->view('user/index', $data);
	}

	public function update()
	{

		$notification = "";

		// If the request method is POST, update the user data in the database and redirect to the update page
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			$data = [];

			$person = $this->userModel->findPersonById($_SESSION['id']);

			$data += $this->validateUpdatePerson($data, $_POST);

			if ($person->Username != $_POST['username']) {
				echo "username is different";
				$data += $this->validateUsername($data, $_POST);
			}

			if ($person->Email != $_POST['email']) {
				echo "email is different";
				$data += $this->validateEmail($data, $_POST);
			}



			if (array_key_exists("notification", $data)) {
				$notification = $data["notification"];
			}

			if (!array_key_exists("notification", $data)) {
				$result = $this->userModel->updatePerson($_POST);

				if ($result) {
					$notification = "Account updaten succesvol, u wordt binnen 3 seconden herleid";
					header("Refresh: 3; url=" . URLROOT . "user/update");
				} else {
					$notification = "Er is iets fouts gegaan bij het creëeren van een account, probeer later opnieuw of neem contact op";
				}
			}
		}
		// If the request method is not POST, retrieve the user data and pass it to the update page
		$person = $this->userModel->findPersonById($_SESSION['id']);



		// Create an array with the user data
		$data = [
			'title' => 'Profile',
			'firstname' => $person->Firstname,
			'infix' => $person->Infix,
			'lastname' => $person->Lastname,
			'username' => $person->Username,
			'email' => $person->Email,
			'mobile' => $person->Mobile,
			'notification' => $notification
		];

		// Pass the array to the update page
		$this->view('user/update', $data);
	}

	public function delete()
	{
		// Delete the user data from the database and redirect to the register page
		echo "U heeft succesvol uw account verwijderd";
		$this->userModel->deletePerson($_SESSION['id']);

		header("Refresh: 3; url=" . URLROOT . "user/index");
	}

	public function register()
	{
		// Initialize variables for future use
		$data = ["notification" => "", "success" => ""];

		// Code block executes when a POST array is passed, otherwise just loads page as normal
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			try {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

				// Validates all input data for incorrect inputs
				$data = $this->validateCreatePerson($data, $_POST);

				// If an error occurs in validateCreatePerson, data["notification"] will be bigger than 0
				if (strlen($data["notification"]) < 1) {

					// Create person (and the accompanying user and contact rows)
					$result = $this->userModel->createPerson($_POST);

					if ($result) {
						$data['notification'] = "Account creëeren succesvol, u wordt binnen 3 seconden herleid";

						// For making the notification green
						$data['success'] = "success";
						header("Refresh: 3; url=" . URLROOT . "user/login");
					} else {
						$data['notification'] = "Er is iets fouts gegaan bij het creëeren van een account, probeer later opnieuw of neem contact op";
					}
				}
			} catch (PDOException $e) {
				echo $e;
				$data['notification'] = "Er is iets fouts gegaan bij het creëeren van een account, probeer later opnieuw of neem contact op met een admin";
			}
		}
		$this->view('user/register', $data);
	}

	public function login()
	{
		// Initialize variables for future use
		$data = ["notification" => "", "success" => ""];

		// Code block executes when a POST array is passed, otherwise just loads page as normal
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			try {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

				// Look for user with userString, which can be either an email or a username
				$result = $this->userModel->findPersonByEmailOrUsername($_POST['userString']);
				if ($result) {
					if (password_verify($_POST['password'], $result->Password)) {
						// Find userrole by personId
						$user = $this->userModel->findRoleByPersonId($result->Id);

						// Save variables in global session variable
						$_SESSION['id'] = $result->Id;
						$_SESSION['role'] = $user->Role;

						$data['notification'] = "Inloggen succesvol, u wordt binnen 3 seconden herleid";
						$data['success'] = "success";

						header("Refresh: 3; url=" . URLROOT);
					} else {
						$data['notification'] = "Incorrecte inloggegevens";
					}
				} else {
					$data['notification'] = "Incorrecte inloggegevens";
				}
			} catch (PDOException $e) {
				echo $e;
				$data['notification'] = "Er is iets fouts gegaan bij het inloggen, probeer later opnieuw of neem contact op met een admin";
			}
		}
		$this->view('user/login', $data);
	}

	public function logout()
	{
		unset($_SESSION["id"]);
		session_destroy();

		header("Location: " . URLROOT);
	}

	private function validateCreatePerson($data, $post)
	{
		if ($post['password'] != $post['repeat-password'])
			$data['notification'] = "Repeat password does not match with password";
		else if (!$post['terms'])
			$data['notification'] = "Please accept the Terms of Use";
		else {
			$data = $this->validateUpdatePerson($data, $post);
		}

		return ($data);
	}

	private function validateUsername($data, $post)
	{
		if ($this->userModel->findUsername($post['username'])) {
			$data['notification'] = "This username has already been used";
		}
		return ($data);
	}

	private function validateEmail($data, $post)
	{
		if ($this->userModel->findEmail($post['email'])) {
			$data['notification'] = "This email has already been used";
		}
		return ($data);
	}

	private function validateUpdatePerson($data, $post)
	{
		foreach ($post as $key => $value) {
			if (empty($value)) {
				if ($key != "infix") {
					$data['notification'] = "Not all required fields have been filled in";
					// $data['notification'] = "De '$key' veld is niet ingevuld";
					return ($data);
				}
			}
		}
		if (strlen($post['firstname']) > 50)
			$data['notification'] = "Firstname may not contain more than 50 characters";
		else if (strlen($post['lastname']) > 50)
			$data['notification'] = "Lastname may not contain more than 50 characters";
		else if (strlen($post['username']) > 50)
			$data['notification'] = "Username may not contain more than 50 characters";
		else if (strlen($post['email']) > 50)
			$data['notification'] = "Email may not contain more than 50 characters";
		else if (strlen($post['mobile']) > 15)
			$data['notification'] = "Mobile number may not contain more than 15 characters";
		else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
			$data['notification'] = "Email is not in correct format";
		else if (!ctype_digit($post['mobile']))
			$data['notification'] = "Mobile number may only contain numbers";
		return ($data);
	}

	function deleteAccount()
	{
		echo "delete account";
	}
}
