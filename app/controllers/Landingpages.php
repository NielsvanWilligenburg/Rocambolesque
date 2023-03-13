<?php

class Landingpages extends Controller
{
	public function __construct()
	{
		session_start();
		var_dump($_SESSION);
	}

	public function index()
	{
		$this->view('index');
	}
}
