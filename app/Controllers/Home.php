<?php

namespace App\Controllers;
include './vendor/autoload.php';
class Home extends BaseController
{
    
    private $templates;
    
    public function __construct() {
        


    }
    
    public function index()
    {

        // print_r(APPPATH. 'Views');
        $data = [
            "title" => "Lectura Rápida",
        ];

        $data = [
            "title" => "Catálogo de Libros",
        ];
        $data = ['data' => $data];

        echo view('pages/v_inicio', $data);
        echo view('_main', $data);
    }
    
    
}
