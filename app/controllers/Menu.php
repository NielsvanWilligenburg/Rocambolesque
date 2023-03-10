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
        // Laat de model de gegevens uit de database halen via method getMenuAppetizers()
        $menuRecordAppetizer = $this->menuModel->getMenuAppetizers();

        $rows = '';
        foreach ($menuRecordAppetizer as $value) {
            $rows .= "<tr>
                         <td>$value->Name</td>
                         <td>$value->Ingredients</td>
                         <td>$value->Category</td>
                         <td>$value->Course</td>
                      </tr>";
        }

        // Stuur de gegevens uit de model naar de view via het $data array
        $data = [
            'title' => 'Appetizers',
            'rows' => $rows
        ];

        $this->view('menu/index', $data);



        // // Laat de model de gegevens uit de database halen via method getMenuMain()
        // $menuRecordMain = $this->menuModel->getMenuMain();

        // $rows1 = '';
        // foreach ($menuRecordMain as $value) {
        //     $rows1 .= "<tr>
        //                  <td>$value->Name</td>
        //                  <td>$value->Ingredients</td>
        //                  <td>$value->Category</td>
        //                  <td>$value->Course</td>
        //               </tr>";
        // }

        // // Stuur de gegevens uit de model naar de view via het $data array
        // $data1 = [
        //     'title' => 'Winter Menu',
        //     'rows1' => $rows1
        // ];

        // $this->view('menu/index', $data1);
    }



    
    /* Werkt nog niet */

    public function updateMenu()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->menuModel->updateMenu($_POST);

            header("Location: " . URLROOT . "/menu/update");
        } else {
            $menu = $this->menuModel->findMenuById(2);


            $data = [
                'title' => 'Menu',
                'name' => $menu->Name,
                'ingredients' => $menu->Ingredients,
                'category' => $menu->Category,
                'course' => $menu->Course
            ];

            $this->view('menu/update', $data);
        }
    }
}
