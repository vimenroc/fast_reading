<?php
namespace App\Libraries;

class L_SideBar
{

    function DibujarContenido(){
        $session = session();
        $data['usuario'] = $session->get('usuario');
        if($session->get('usuario')){
            $data['botónUsuario'] = '<li class="nav-item"><a href="'.base_url('logout').'" class="col-12 btn btn-success"><i class="fa fa-user"></i> Cerrar Sesión</a></li>';
        }else{
            $data['botónUsuario'] = '<li class="nav-item"><a href="'.base_url('login').'" class="col-12 btn btn-primary"><i class="fa fa-user"></i> Inicar Sesión</a></li>';
        }
        return view('componentes/v_sidebar', $data);
    }
}
