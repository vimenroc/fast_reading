<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        // print_r(APPPATH. 'Views');
        $data = [
            "title" => "Lectura Rápida",
        ];
        $session = session();
        
        
        if($session->get('usuario')){
            $usuario = $session->get('usuario');
            echo $usuario->username;
            $data['botones'] = [
                [
                    'nombre' => 'Favoritos',
                    'ícono' => 'star',
                    'href' => base_url("usuario/$usuario->username/favoritos"),
                ],
            ];
        }else{
            $data['botones'] = null;
        }
        

        return view('pages/v_inicio', $data);
    }
}
