<?php

namespace App\Models;

class E_Respuesta 
{
    public $status;
    private function setStatus($status){
        $this->status = $status;
    }    
    private function getStatus(){
        return $this->status;
    }

    public $msg;
    private function setMsg($msg){
        $this->msg = $msg;
    }
    private function getMsg(){
        return $this->msg;
    }
    
    public $data;
    private function setData($data){
        $this->data = $data;
    }
    private function getData(){
        return $this->data;
    }

    public $error;
    private function setError($error){
        $this->error = $error;
    }
    private function getError(){
        return $this->error;
    }

    public $alert;
    private function setAlert($alert){
        $this->alert = $alert;
    }
    private function getAlert(){
        return $this->alert;
    }
    


}