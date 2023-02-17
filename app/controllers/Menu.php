<?php

class Menu extends Controller
{
    private $menuModel;

    public function __construct()
    {
        $this->menuModel = $this->model('MenuModel');
    }

    public function index()
    {
        $this->view('menu/index');
    }
}
