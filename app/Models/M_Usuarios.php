<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\E_Respuesta;
use App\Models\E_LoginRequest;

class M_Usuarios extends Model
{   
    private $secretKey;

   

    private $QCatálogoDeIdiomas = "SELECT
	    idioma.ID AS 'id',
        idioma.IDIOMA AS `idioma`,
        idioma.HTML_ICON AS 'ícono'
        FROM fastreading_cat_idiomas AS idioma
        ";
    
    
    public function __construct() {       
        $this->db = \Config\Database::connect();
        $this->secretKey =  $_ENV['SECRET_KEY'];
    }

    function Login($data){
        $respuesta = new E_Respuesta();
        $loginData = new E_LoginRequest();
        $builder = $this->db->table('fastreading_t_usuarios');
        $builder->select('ID, USUARIO_NOMBRE, PERSONA_NOMBRE, PERSONA_PA, PERSONA_SA, USUARIO_FOTO, PW');
        $builder->where('USUARIO_NOMBRE', $data['usuario']);
        $builder->where('ACTIVO', 1);
        $query = $builder->get();
        $usuario = $query->getRow();
        if ($usuario) {
            if ($this->Desencriptar($usuario->PW) == $data['pw']) {
                unset($usuario->PW);
                unset($usuario->ACTIVO);
                $loginData->username = $usuario->USUARIO_NOMBRE;
                $loginData->userID = $usuario->ID;

                $respuesta->data = $loginData;
                $respuesta->msg = "Inicio de sesión exitoso";
                $respuesta->status = true;
                $respuesta->alert = "success";
                $session = session();
                $session->set('usuario', $loginData);
            }else{
                $respuesta->status = false;
                $respuesta->alert = "danger";
                $respuesta->error = "Contraseña incorrecta";
            }
        }else{
            $respuesta->status = false;
            $respuesta->alert = "warning";
            $respuesta->error = "Usuario no encontrado";
        }


        return $respuesta;
    }

    function Logout(){
        $respuesta = new E_Respuesta();
        $session = session();
        $session->destroy();
        $respuesta->status = true;
        $respuesta->msg = "Sesión cerrada";
        $respuesta->alert = "success";

        return $respuesta;
    
    }
    
    function BUsuarioCU($data){
        $respuesta = new E_Respuesta();

        $insert = [
            'PERSONA_NOMBRE' => $data['pnombre'],
            'PERSONA_PA' => $data['ppa'],
            'PERSONA_SA' => $data['psa'],
            'USUARIO_NOMBRE' => $data['unombre'],
            'USUARIO_FOTO' => '',
            'ACTIVO' => 1,
            'PW' => $this->Encriptar($data['pw'])
        ];
        $builder = $this->db->table('fastreading_t_usuarios');
        switch ($data['método']) {
            case null:
            case 'C':
                $f = $builder->insert($insert);
                break;
            case 'U':
                $builder->where('ID', $data['id']);
                $f = $builder->update($insert);
                break;
            
            default:
                # code...
                break;
        }
        
        if ($f) {
            $respuesta->data['lastID'] = $this->db->insertID();
            $respuesta->msg = "Registro exitoso";
            $respuesta->status = true;
            $respuesta->alert = "success";
        }else{
            $respuesta->status = false;
            $respuesta->error = $builder->getError();
        }

        return $respuesta;   
    }
    
    private function Encriptar($palabraParaEncriptar){
        $pwEncriptado = $palabraParaEncriptar;
        $key = $this->secretKey;
        $method = "AES-256-CBC";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encrypted = openssl_encrypt($pwEncriptado, $method, $key, 0, $iv);
        $encrypted = base64_encode($iv.$encrypted);

        return $encrypted;
    }

    private function Desencriptar($palabraParaDesencriptar){
        $encrypted = base64_decode($palabraParaDesencriptar);
        $method = "AES-256-CBC";
        $key = $this->secretKey;
        $iv = substr($encrypted, 0, openssl_cipher_iv_length($method));
        $encrypted = substr($encrypted, openssl_cipher_iv_length($method));
        $decrypted = openssl_decrypt($encrypted, $method, $key, 0, $iv);

        return $decrypted;
    }
    private function EncryptionExample($stringToEncrypt){
        // Define the data to encrypt
        $data = $stringToEncrypt;

        // Define the secret key
        $key = $this->secretKey;

        // Define the encryption method
        $method = "AES-256-CBC";

        // Generate a random initialization vector (IV)
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

        // Encrypt the data
        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);

        // Concatenate the IV and the encrypted data
        $encrypted = base64_encode($iv.$encrypted);

        // Display the encrypted data
        echo "Encrypted: ".$encrypted."\n";

        // Decode the encrypted data
        $encrypted = base64_decode($encrypted);

        // Extract the IV and the encrypted data
        $iv = substr($encrypted, 0, openssl_cipher_iv_length($method));
        $encrypted = substr($encrypted, openssl_cipher_iv_length($method));

        // Decrypt the data
        $decrypted = openssl_decrypt($encrypted, $method, $key, 0, $iv);

        // Display the decrypted data
        echo "Decrypted: ".$decrypted."\n";
    }
    
}