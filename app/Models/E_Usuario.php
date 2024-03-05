<?php

namespace App\Models;

class E_Usuario 
{
    public $PW;
    private function setPW($PW){
        $this->PW = $this->Encriptar($PW);
    }
    private function getPW(){
        return $this->PW;
    }

    public $PERSONA_NOMBRE;
    private function setPERSONA_NOMBRE($PERSONA_NOMBRE){
        $this->PERSONA_NOMBRE = $PERSONA_NOMBRE;
    }
    private function getPERSONA_NOMBRE(){
        return $this->PERSONA_NOMBRE;
    }

    public $PERSONA_PA;
    private function setPERSONA_PA($PERSONA_PA){
        $this->PERSONA_PA = $PERSONA_PA;
    }
    private function getPERSONA_PA(){
        return $this->PERSONA_PA;
    }

    public $PERSONA_SA;
    private function setPERSONA_SA($PERSONA_SA){
        $this->PERSONA_SA = $PERSONA_SA;
    }
    private function getPERSONA_SA(){
        return $this->PERSONA_SA;
    }

    public $USUARIO_NOMBRE;
    private function setUSUARIO_NOMBRE($USUARIO_NOMBRE){
        $this->USUARIO_NOMBRE = $USUARIO_NOMBRE;
    }

    public $USUARIO_FOTO;
    private function setUSUARIO_FOTO($USUARIO_FOTO){
        $this->USUARIO_FOTO = $USUARIO_FOTO;
    }
    private function getUSUARIO_FOTO(){
        return $this->USUARIO_FOTO;
    }


    private function Encriptar($palabraParaEncriptar){
        $PWEncriptado = $palabraParaEncriptar;
        $key = $this->secretKey;
        $method = "AES-256-CBC";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encrypted = openssl_encrypt($PWEncriptado, $method, $key, 0, $iv);
        $encrypted = base64_encode($iv.$encrypted);

        return $encrypted;
    }

}