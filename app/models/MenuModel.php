<?php

class MenuModel
{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMenu()
    {
        $this->db->query('SELECT * FROM main');

        return $this->db->resultSet();
    }
}
