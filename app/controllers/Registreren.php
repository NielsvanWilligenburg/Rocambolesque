<?php

class Registreren extends Controller
{
	private $registrerenModel;

	public function __construct()
	{
		$this->registrerenModel = $this->model('RegistrerenModel');
	}

	public function index()
	{
		$data = [
			'title' => 'Example',
			'description' => 'This is the example page'
		];

		$this->view('registreren/index', $data);
	}
}
