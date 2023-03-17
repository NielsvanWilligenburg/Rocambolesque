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
		// Check if the request method is POST, and sanitize the POST variables
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Filter de POST variabelen
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			// If the length of the username is greater than 16 characters, display an error message and redirect after 3 seconds
			if (strlen($_POST['username']) > 16) {
				echo "Username is te lang, maximaal 16 karakters";
				header("Refresh: 3; url=" . URLROOT . "register/update");
			} else {
				// If the length of the username is less than or equal to 16 characters, update the user data in the database and redirect to the update page
				$this->registerModel->updatePerson($_POST);

				header("Location: " . URLROOT . "/register/update");
			}
		} else {
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
				'mobile' => $person->Mobile
			];

			// Pass the data to the update page
			$this->view('register/update', $data);
		}
	}

	public function delete()
	{
		// Delete the user data from the database and redirect to the register page
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
		else if ($post['password'] != $post['repeat-password'])
			$data['notification'] = "Repeat password does not match with password";
		else if (!$post['terms'])
			$data['notification'] = "Please accept the Terms of Use";
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
