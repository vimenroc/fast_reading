<?php

namespace App\Models;

class E_LoginRequest
{
    public $username;
    private function setUsername($username){
        $this->username = $username;
    }
    private function getUsername(){
        return $this->username;
    }

    public $userID;
    private function setUserID($userID){
        $this->userID = $userID;
    }
    private function getUserID(){
        return $this->userID;
    }
    
    


}