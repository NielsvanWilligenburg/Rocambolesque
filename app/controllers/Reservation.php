<?php

class Reservation extends Controller
{
    private $reservationModel;

    public function __construct(){
        $this->reservationModel = $this->model('ReservationModel');
        session_start();  
    }

    public function index(){

        $this->view('reservation/reservation');
    }

    public function createReservation();
}