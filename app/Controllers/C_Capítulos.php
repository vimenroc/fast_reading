<?php

namespace App\Controllers;
use App\Models\M_Capítulos;
use CodeIgniter\HTTP\IncomingRequest;

class C_Capítulos extends BaseController
{
    public function __construct() {
        $this->M_Capítulos = new M_Capítulos();
        
    }
    
    public function index()
    {
        return view('welcome_message');
    }

function VCapítulo($IDcapítulo = null){
        $data = [
            "title" => "Libro",
            "IDcapítulo" => $IDcapítulo
        ];
        
        
        echo view('libros/v_capítulo_leer', $data);
    }
    
    function VCapítuloCU($IDlibro = null, $IDcapítulo = null){

        $data = $this->M_Capítulos->VCapítuloCU($IDlibro, $IDcapítulo);
        $data["title"] = "Nuevo Capítulo";
        echo view('libros/v_capítulo_cu', $data);
    }
    
    function JCapítuloCU(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Capítulos->JCapítuloCU($request));
    }
    
    function JCapítuloDetalles(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Capítulos->JCapítuloDetalles($request));
    }
    
    function BuscarCapítulosPorLibro(){
        $request = request();
        echo json_encode( $this->M_Capítulos->BuscarCapítulos($request));
    }

    public function JCapítulos(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Capítulos->JCapítulos($request));
    }

}