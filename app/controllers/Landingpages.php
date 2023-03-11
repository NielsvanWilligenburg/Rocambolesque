<?php

class Landingpages extends Controller
{
	public function __construct()
	{
		session_start();
	}

	public function index()
	{
		$this->view('index');
	}
}
