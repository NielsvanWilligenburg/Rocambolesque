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
		$data = [
			'title' => 'Profile',
			'description' => 'This is the example page'
		];

		$this->view('register/update', $data);
	}
}
