<?php

namespace App\Controllers;
use App\Models\M_Libros;
use CodeIgniter\HTTP\IncomingRequest;

class C_Libros extends BaseController
{
    public function __construct() {
        $this->M_Libros = new M_Libros();
        
    }
    
    public function index()
    {
        return view('welcome_message');
    }
    
    public function VCatálogo(){
        $data = [
            "title" => "Catálogo de Libros"
        ];
        $data = ['data' => $data];

        echo view('libros/v_catálogo', $data);
        echo view('_main', $data);
    }
    
    public function JCatálogo(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JCatálogo($request));
    }
    
    public function VLibro($IDlibro = null){
        $data = [
            "title" => "Catálogo de Libros",
            "IDlibro" => $IDlibro
        ];
        $data = ['data' => $data];

        echo view('libros/v_libro', $data);
        echo view('_main', $data);
    }
    
    public function JLibro(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JLibro($request));
    }
    
    public function JCapítulos(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JCapítulos($request));
    }
    
    
    // Función para cuando se agrega un nuevo libro o se edita la información de uno
    // Ya que utilizan los mismos campos para agregar y editar, se usa una sola función
    function VLibroCU($IDlibro = null){
        $data = $this->M_Libros->VLibroCU($IDlibro);
        $data = ['data' => $data];

        echo view('libros/v_libro_cu', $data);
        echo view('_main', $data);
    }
    
    public function VLibroDetalles($IDlibro = null){
        $data = [
            "title" => "Cargando...",
            "IDlibro" => $IDlibro
        ];
        $data = ['data' => $data];

        echo view('libros/v_libro_detalles', $data);
        echo view('_main', $data);
    }
    
    public function JLibroCU(){
        $request = request();
        $request = $request->getPost();
        echo json_encode($this->M_Libros->JLibroCU($request));
    }
    
    // Fución de prueba
    function VCapítulo($IDcapítulo = null){
        $data = [
            "title" => "Libro",
            "IDcapítulo" => $IDcapítulo
        ];
        $data = ['data' => $data];
        
        echo view('libros/v_capítulo_leer', $data);
        echo view('_main', $data);
    }
    
    function VCapítuloCU($IDlibro = null, $IDcapítulo = null){
        $data = $this->M_Libros->VCapítuloCU($IDlibro, $IDcapítulo);
        $data = ['data' => $data];
        
        echo view('libros/v_capítulo_cu', $data);
        echo view('_main', $data);
    }
    
    function JCapítuloCU(){
        $request = request();
        $request = $request->getPost();
        // echo json_encode($request);
        echo json_encode( $this->M_Libros->JCapítuloCU($request));
    }
    
    function JCapítuloDetalles(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JCapítuloDetalles($request));
    }
    
    function BuscarCapítulosPorLibro(){
        $request = request();
        echo json_encode( $this->M_Libros->BuscarCapítulos($request));
    }
    
}
