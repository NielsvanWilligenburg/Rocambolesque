<?php

class Register extends Controller
{
	private $registerModel;

	public function __construct()
	{
		$this->registerModel = $this->model('RegisterModel');
		session_start();
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

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			$this->registerModel->updatePerson($_POST);

			header("Location: " . URLROOT . "/register/update");
		} else {
			$person = $this->registerModel->findPersonById(13);


			$data = [
				'title' => 'Profile',
				'firstname' => $person->Firstname,
				'infix' => $person->Infix,
				'lastname' => $person->Lastname,
				'email' => $person->Email,
				'mobile' => $person->Mobile
			];

			$this->view('register/update', $data);
		}
	}

	public function delete()
	{
		echo "delete";
		$this->registerModel->deletePerson(13);
	}

	public function register()
	{
		$data = ["notification" => ""];
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

						// $_SESSION["userrole"] = $result->userrole;
						$data['notification'] = "Inloggen succesvol, u wordt binnen 3 seconden herleid";
						header("Refresh: 3; url=" . URLROOT . "register/");
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
		$this->view('register/logout');
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
}
