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
		// Check if the request method is POST, and sanitize the POST variables
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Filter de POST variabelen
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			// If the length of the username is greater than 16 characters, display an error message and redirect after 3 seconds
			if (strlen($_POST['username']) > 16) {
				echo "Username is te lang, maximaal 16 karakters";
				header("Refresh: 3; url=" . URLROOT . "user/update");
			} else {
				// If the length of the username is less than or equal to 16 characters, update the user data in the database and redirect to the update page
				$this->userModel->updatePerson($_POST);

				header("Location: " . URLROOT . "/user/update");
			}
		} else {
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
				'mobile' => $person->Mobile
			];

			// Pass the data to the update page
			$this->view('user/update', $data);
		}
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
		$data = ["notification" => "" , "success" => ""];

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
		foreach ($post as $key => $value) {
			if (empty($value)) {
				if ($key != "infix") {
					$data['notification'] = "Niet alle verplichte velden zijn ingevuld";
					// $data['notification'] = "De '$key' veld is niet ingevuld";
					return ($data);
				}
			}
		}
		if (strlen($post['firstname']) > 50)
			$data['notification'] = "Voornaam mag niet meer dan 50 karakters bevatten";
		else if (strlen($post['lastname']) > 50)
			$data['notification'] = "Achternaam mag niet meer dan 50 karakters bevatten";
		else if (strlen($post['username']) > 50)
			$data['notification'] = "Gebruikersnaam mag niet meer dan 50 karakters bevatten";
		else if (strlen($post['email']) > 50)
			$data['notification'] = "Email mag niet meer dan 50 karakters bevatten";
		else if (strlen($post['mobile']) > 15)
			$data['notification'] = "Mobiele nummer mag niet meer dan 50 karakters bevatten";
		else if ($post['password'] != $post['repeat-password'])
			$data['notification'] = "De wachtwoorden komen niet overeen";
		else if (empty($post['terms']))
			$data['notification'] = "Accepteer de Terms of Use";
		else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
			$data['notification'] = "Email is niet in de juiste formaat";
		else if (!ctype_digit($post['mobile']))
			$data['notification'] = "Mobiele nummer mag alleen cijfers bevatten";
		else if ($this->userModel->findEmail($post['email']))
			$data['notification'] = "Deze email is al in gebruik";
		else if ($this->userModel->findUsername($post['username']))
			$data['notification'] = "Deze gebruikersnaam is al in gebruik";
		return ($data);
	}

	function deleteAccount()
	{
		echo "delete account";
	}
}
