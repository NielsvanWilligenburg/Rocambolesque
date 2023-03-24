<?php

class Register extends Controller
{
	private $registerModel;

	public function __construct()
	{
		$this->registerModel = $this->model('RegisterModel');
	}

	public function index()
	{
		$data = [
			'title' => 'Example',
			'description' => 'This is the example page'
		];

		$this->view('register/index', $data);
	}

	public function update()
	{

		$notification = "";

		// If the request method is POST, update the user data in the database and redirect to the update page
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			var_dump($_POST);

			$data = [];

			$data = $this->validateUpdatePerson($data, $_POST);
			$notification = $data["notification"];

			if (strlen($data["notification"]) < 1) {
				var_dump($_POST);
				$result = $this->registerModel->updatePerson($_POST);

				if ($result) {
					$notification = "Account updaten succesvol, u wordt binnen 3 seconden herleid";
					header("Refresh: 3; url=" . URLROOT . "register/update");
				} else {
					$notification = "Er is iets fouts gegaan bij het creëeren van een account, probeer later opnieuw of neem contact op";
				}
			}
		} 
			// If the request method is not POST, retrieve the user data and pass it to the update page
			$person = $this->registerModel->findPersonById($_SESSION['id']);

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
			$this->view('register/update', $data);
	}

	public function delete()
	{
		echo "U heeft succesvol uw account verwijderd";
		$this->registerModel->deletePerson($_SESSION['id']);

		header("Refresh: 3; url=" . URLROOT . "register/index");
	}

	public function register()
	{
		$notification = "";
		$data = ["notification" => $notification];
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			try {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

				$data = $this->validateCreatePerson($data, $_POST);

				if (strlen($data["notification"]) < 1) {
					$result = $this->registerModel->createPerson($_POST);

					if ($result) {
						$data['notification'] = "Account creëeren succesvol, u wordt binnen 3 seconden herleid";
						header("Refresh: 3; url=" . URLROOT . "register/login");
					} else {
						$data['notification'] = "Er is iets fouts gegaan bij het creëeren van een account, probeer later opnieuw of neem contact op";
					}
				}
			} catch (PDOException $e) {
				echo $e;
				$data['notification'] = "Er is iets fouts gegaan bij het creëeren van een account, probeer later opnieuw of neem contact op met een admin";
			}
		}
		$this->view('register/register', $data);
	}

	public function login()
	{
		$data = ["notification" => ""];
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			try {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

				$result = $this->registerModel->findPersonByEmailOrUsername($_POST['userString']);
				if ($result) {
					if (password_verify($_POST['password'], $result->Password)) {
						// login
						$_SESSION['id'] = $result->Id;
						var_dump($_SESSION);
						// $_SESSION["userrole"] = $result->userrole;
						$data['notification'] = "Inloggen succesvol, u wordt binnen 3 seconden herleid";

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
		$this->view('register/login', $data);
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
		else if ($this->registerModel->findEmail($post['email']))
			$data['notification'] = "This email has already been used";
		else if ($this->registerModel->findUsername($post['username']))
			$data['notification'] = "This username has already been used";
		return ($data);
	}

	function deleteAccount()
	{
		echo "delete account";
	}
}
