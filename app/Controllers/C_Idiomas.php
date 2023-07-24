<?php

namespace App\Controllers;
use App\Models\M_Idiomas;
use CodeIgniter\HTTP\IncomingRequest;

class C_Idiomas extends BaseController
{
    public function __construct() {
        $this->m_Idiomas = new M_Idiomas();
        
    }

    public function index()
    {
        return view('welcome_message');
    }
    
    function VCatálogo(){
    }
    
    function JCatálogo(){
        echo json_encode($this->m_Idiomas->JCatálogo());
    }


}