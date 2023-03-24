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
        // An array to store the notification messages
        $data = ["notification" => ""]; 

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try{
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

                // Finding the table ID by calling the ReservationModel's findTable method
                $tableId = $this->reservationModel->findTable($_POST);

                // Finding the opening time ID by calling the dayNameVar method
                $openingtimeId = $this->dayNameVar($_POST['date']); 
                
                // Validating the input data
                $data = $this->validateCreateReservation($data, $_POST, $tableId); 
                
                if (strlen($data["notification"]) < 1) {
                    // If the validation is successful, create a new reservation
                    $result = $this->reservationModel->createReservation($_POST, $_SESSION['id'], $tableId->Id, $openingtimeId->Id);
                    if ($result) {
                        // If the reservation is successful, set the success notification message
						$data['notification'] = "Reservation succesfull";
						header("Refresh: 3; url=" . URLROOT . "reservation/createReservation");
					} else {
                        // If there is an error creating the reservation give error message
						$data['notification'] = "Something went wrong, please try again or contact us.";
					}
                }
            } catch (PDOException $e) {
                // If there is an error, catch the exception and give error message
				echo $e;
				$data['notification'] = "Something went wrong, please try again or contact us.";
			}
        }
        else {
            $data['notification'] = 'make a reservation';
        }
        $this->view('reservation/createReservation', $data);
    }
 
	public function reservations($id = null)
	{
		$result = "";
		// When id is null, try to access all reservations, if id is set, gets reservations of personId
		if ($id)
		{
			$result = $this->reservationModel->getReservationsByPersonId($id);
			if (!$result)
			{
				
			}
		} else
		{
			$result = $this->reservationModel->getReservations($id);
			if (!$result)
			{

			}
		}
			
		$data = ["reservations" => $result];

		$this->view('reservation/reservations', $data);
	}

    public function dayNameVar($date){
        // Helper method to find the day name
        $i = strtotime($date);
        $day   = date('d',$i);
        $month = date('m',$i);
        $year  = date('Y',$i);
        return $this->reservationModel->findOpeningtime(date('l', mktime(0, 0, 0, $month, $day, $year)));
    }

    public function validateCreateReservation($data, $post, $tableId){
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
        else if ($tableId == null)
			$data['notification'] = "No tables available";
		return($data);
    }

}