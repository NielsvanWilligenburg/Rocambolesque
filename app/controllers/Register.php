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
						header("Refresh: 3; url=" . URLROOT . "/register/login");
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
						header("Refresh: 3; url=" . URLROOT . "/register/");
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
				$data['notification'] = "Niet alle velden zijn ingevuld";
				// $data['notification'] = "De '$key' veld is niet ingevuld";
				return ($data);
			}
		}
		if (strlen($post['firstname']) > 50)
			$data['notification'] = "Voornaam mag niet meer dan 50 karakter bevatten";
		else if (strlen($post['lastname']) > 50)
			$data['notification'] = "Achternaam mag niet meer dan 50 karakter bevatten";
		else if (strlen($post['username']) > 50)
			$data['notification'] = "Gebruikersnaam mag niet meer dan 50 karakter bevatten";
		else if (strlen($post['email']) > 50)
			$data['notification'] = "Email mag niet meer dan 50 karakter bevatten";
		else if (strlen($post['mobile']) > 15)
			$data['notification'] = "Mobiele nummer mag niet meer dan 50 karakter bevatten";
		else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
			$data['notification'] = "Vul een geldig email adres in";
		else if (!ctype_digit($post['mobile']))
			$data['notification'] = "Mobiele nummer mag alleen cijfers bevatten";
		else if ($this->registerModel->findEmail($post['email']))
			$data['notification'] = "Dit email adres is al in gebruik";
		else if ($this->registerModel->findUsername($post['username']))
			$data['notification'] = "Deze gebruikersnaam is al in gebruik";
		return ($data);
	}
}
