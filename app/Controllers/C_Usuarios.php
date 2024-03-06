<?php

namespace App\Controllers;
use App\Models\M_Usuarios;
use App\Models\E_Usuario;
use CodeIgniter\HTTP\IncomingRequest;

class C_Usuarios extends BaseController
{
    public function __construct() {
        $this->m_Usuarios = new M_Usuarios();
        
    }

    public function index()
    {
        return "hola";
    }

    public function UsuarioCU($IDUsuario = null){
        echo "nuevo";
    }
    

    public function BUsuarioCU(){
        $request = request();
        $request = $request->getPost();
        
        return json_encode($this->m_Usuarios->BUsuarioCU($request));
    }

    public function VRegistro(){
        $data["title"] = "Registro de Usuario";
        return view('pages/v_registro', $data);
    }

    public function VLogin(){
        $data["title"] = "Iniciar Sesión";
        return view('pages/v_login', $data);
    }
    
    public function VLogout(){
        $data["title"] = "Iniciar Sesión";
        return view('pages/v_logout', $data);
    }


    public function BRegistro(){
        $request = request();
        $request = $request->getPost();
        
        $request['pnombre'] = "";
        $request['ppa'] = "";
        $request['psa'] = "";
        $request['unombre'] = $request['usuario'];
        $request['método'] = "C";
        
        return json_encode($this->m_Usuarios->BUsuarioCU($request));
    }
    
    public function BLogin(){
        helper(['form']);
        $rules = [
            'usuario' => 'required',
            'pw' => 'required',
        ];

        $request = request();
        $request = $request->getPost();
        if ($this->validate($rules)) {
            // echo "valido";
            echo json_encode($this->m_Usuarios->Login($request));
        }else{
            // echo json_encode($this->validator->listErrors());
        }
    }

    public function BLogout(){
        echo json_encode($this->m_Usuarios->Logout());
    }

}