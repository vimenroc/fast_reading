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
    
    
    function VNuevo(){
        $data = [
            "title" => "Nuevo de Libro"
        ];
        $data = ['data' => $data];

        echo view('libros/v_nuevo', $data);
        echo view('_main', $data);
    }
    
    public function JNuevo(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JNuevo($request));
    }
    
    // Función de prueba
    public function GetBook($bookID){
        $homepage = file_get_contents( base_url(). '/libros_json/hard_boiled.json');
        echo $homepage;
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
    
    function VCapítuloNuevo($IDlibro = null){
        $data = [
            "title" => "Libro",
            "IDlibro" => $IDlibro
        ];
        $data = ['data' => $data];
        
        echo view('libros/v_capítulo_nuevo', $data);
        echo view('_main', $data);
    }
    
    function VCapítuloDetalles($IDcapítulo = null){
        $data = [
            "title" => "Capítulo $IDcapítulo",
            "IDcapítulo" => $IDcapítulo
        ];
        $data = ['data' => $data];
        
        echo view('libros/v_capítulo_detalles', $data);
        echo view('_main', $data);
    }
    
    function JCapítulosC(){
        $request = request();
        $request = $request->getPost();
        // echo json_encode($request);
        echo json_encode( $this->M_Libros->JCapítulosC($request));
    }
    
    function JCapítuloDetalles(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JCapítuloDetalles($request));
    }
    
    function JCapítuloDetallesU(){
        $request = request();
        $request = $request->getPost();
        // echo json_encode($request);
        echo json_encode( $this->M_Libros->JCapítuloDetallesU($request));
    }
    
    function BuscarCapítulosPorLibro(){
        $request = request();
        echo json_encode( $this->M_Libros->BuscarCapítulos($request));
    }
    
}
