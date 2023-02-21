<?php

class ReservationModel{
    
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function createReservation($post){
        // $this->db->query("CALL spCreateReservation(:personId, :OpeningTime)")
    }
}