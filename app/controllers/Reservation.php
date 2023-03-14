<?php

class Reservation extends Controller
{
    private $reservationModel;

    public function __construct(){
        $this->reservationModel = $this->model('ReservationModel'); 
    }

    public function index(){

        $this->view('reservation/createReservation');
    }

    public function createReservation(){
        $data = ["notification" => ""];
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try{
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $tableId = $this->reservationModel->findTable($_POST)->Id;
                
                
                $data = $this->validateCreateReservation($data, $_POST);
                
                if(strlen($data["notification"]) < 1) {
                    $result = $this->reservationModel->createReservation($_POST, $_SESSION['id'], $tableId);
                    // var_dump($result); exit;
                    if ($result) {
						$data['notification'] = "Reservation succesfull";
						header("Refresh: 3; url=" . URLROOT . "reservation/createReservation");
					} else {
						$data['notification'] = "Something went wrong, please try again or contact us.";
					}
                }
            } catch (PDOException $e) {
				echo $e;
				$data['notification'] = "Something went wrong, please try again or contact us.";
			}
        }
        else {
            $data['notification'] = 'make a reservation';
        }
        $this->view('reservation/createReservation', $data);
    }

    public function validateCreateReservation($data, $post){
        foreach($post as $key => $value){
            if (empty($value)) {
				if ($key != "children") {
					$data['notification'] = "Not all fields are filled in.";
					return ($data);
				}
			}
        }
        if ($post['guests'] > 4)
			$data['notification'] = "Can't have more than 4 guests at one table";
		else if ($post['children'] > 2)
			$data['notification'] = "Can't have more than 2 children at one table";
		else if ($post['date'] < date("Y-m-d"))
			$data['notification'] = "Please enter a valid date";
		else if ($post['time'] > '20:00:00')
			$data['notification'] = "Please reserve before 20:00, a sitting is 2 hours long";
        else if ($post['time'] < '17:00:00')
			$data['notification'] = "We open at 17:00";
        //var_dump($this->reservationModel->findTable($post['guests'], $post['children'], $post['date'], $post['time'], $post['time']));
        // else if ($this->reservationModel->findTable($post['guests'], $post['children'], $post['date'], $post['time'], $post['time']) == null)
		// 	$data['notification'] = "No tables available";
		// else if ('price check')
		// 	$data['notification'] = "Vul een geldig email adres in";
        // var_dump($data);
		return($data);
    }
}