<?php

namespace App\Controllers;
use App\Models\M_Libros;
use CodeIgniter\HTTP\IncomingRequest;

class C_Libros extends BaseController
{
    public function __construct() {
        $this->M_Libros = new M_Libros();
        
    }

    // VISTAS
    
    public function index()
    {
        return view('welcome_message');
    }
    
    public function VCatálogo(){
        $data = [
            "title" => "Catálogo de Libros"
        ];

        return view('libros/v_catálogo', $data);
    }
    
    public function VLibro($libroID = null){
        $usuario = $this->session->get('usuario');
        if ($usuario) {
            $usuarioID = $usuario->userID;
        }else{
            $usuarioID = null;
        }
        
        $data = [
            "title" => "Catálogo de Libros",
            "libroID" => $libroID, 
            "usuarioID" => $usuarioID,
        ];

        return view('libros/v_libro', $data);
    }
    
    function VFavoritos(){
        $usuario = $this->session->get('usuario');
        if ($usuario) {
            $usuarioID = $usuario->userID;
        }else{
            $usuarioID = null;
            $session->setFlashdata('error', 'Debes iniciar sesión para ver tus favoritos');
            return redirect()->to(base_url('/'));
        }
        $data = [
            "title" => "Favoritos",
            "usuarioID" => $usuarioID,
        ];
        return view('libros/v_favoritos', $data);
    }
    
    // Función para cuando se agrega un nuevo libro o se edita la información de uno
    // Ya que utilizan los mismos campos para agregar y editar, se usa una sola función
    function VLibroCU($IDlibro = null){
        $data = $this->M_Libros->VLibroCU($IDlibro);
        return view('libros/v_libro_cu', $data);
    }
    
    public function VLibroDetalles($IDlibro = null){
        $data = [
            "title" => "Cargando...",
            "IDlibro" => $IDlibro
        ];
        
        echo view('libros/v_libro_detalles', $data);
        echo view('_main', $data);
    }

    // FIN DE VISTAS


    // BACK END

    public function JCatálogo(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JCatálogo($request));
    }

    public function JLibro(){
        $request = request();
        $request = $request->getPost();
        echo json_encode( $this->M_Libros->JLibro($request));
    }
    
    public function JLibroCU(){
        $request = request();
        $request = $request->getPost();
        echo json_encode($this->M_Libros->JLibroCU($request));
    }

    public function JRevisarFavoritos(){
        $request = request();
        $request = $request->getPost();
        echo json_encode($this->M_Libros->JRevisarFavoritos($request));
    }

    public function JFavoritos(){
        $request = request();
        $request = $request->getPost();
        echo json_encode($this->M_Libros->JFavoritos($request));
    }

    public function JFavoritosD(){
        $request = request();
        $request = $request->getPost();
        $request['método'] = "D";
        echo json_encode($this->M_Libros->JFavoritosCD($request));
    }
    public function JFavoritosC(){
        $request = request();
        $request = $request->getPost();
        $request['método'] = "C";
        echo json_encode($this->M_Libros->JFavoritosCD($request));
    }
    
    // FIN DE BACK END
    
    
}
