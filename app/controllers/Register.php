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

	public function register()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			try {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

				$result = $this->registerModel->createPerson($_POST);
				exit;
				// header("Location: " . URLROOT . "/register/");
			} catch (PDOException $e) {
				echo "Het creëeren is niet gelukt";
				echo $e;
				// header("Refresh:3; url=" . URLROOT . "/lessen/onderwerpen/" . $id);
			}
		}
		$data = [];
		$this->view('register/register', $data);
	}

	private function validateCreatePerson($data)
	{
		// iets van checks enzo
		// if (strlen($data['topic']) > 255)
		// $data['topicError'] = "De nieuwe opmerking bevat meer dan 255 karakters";
		return ($data);
	}
}
