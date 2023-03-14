<?php

class ReservationModel{
    
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function createReservation($post, $personId, $tableId){
        $this->db->query("CALL spCreateReservation(:PersonId, :OpeningtimeId, :TableId, :Guests, :Children, :Date, :Time)");
        $this->db->bind(':PersonId', $personId, PDO::PARAM_INT);
        $this->db->bind(':OpeningtimeId', 1, PDO::PARAM_INT);
        $this->db->bind(':TableId', $tableId, PDO::PARAM_INT);
        $this->db->bind(':Guests', $post['guests'], PDO::PARAM_INT);
        $this->db->bind(':Children', $post['children'], PDO::PARAM_INT);
        $this->db->bind(':Date', $post['date'], PDO::PARAM_STR);
        $this->db->bind(':Time', $post['time'], PDO::PARAM_STR);
        return $this->db->execute();
    }

    public function findTable($post){
        $this->db->query("CALL spFindTable(:guestCheck, :childCheck, :dateCheck, :timeStartCheck)");
        $this->db->bind(':guestCheck', $post['guests'], PDO::PARAM_INT);
        $this->db->bind(':childCheck', $post['children'], PDO::PARAM_INT);
        $this->db->bind(':dateCheck', $post['date'], PDO::PARAM_STR);
        $this->db->bind(':timeStartCheck', $post['time'], PDO::PARAM_STR);
        return $this->db->single();
    }
}