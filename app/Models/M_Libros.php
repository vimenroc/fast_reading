<?php
/*
Modelo que maneja lo referente a libros y capítulos.
*/

namespace App\Models;
use CodeIgniter\Model;

class M_Libros extends Model
{
    private $idioma = "ENG";
    private $idiomaID = 1;
    private $libroID = 0;
    private $reseña = "";
    private $cambioF = false;
    
    private $result = [
        'status' => false,
        'msg' => '',
        'data' => [],
        'error' => [],
        'alert' => '',
    ];
    
    private $QCapítulosDeLibro = "SELECT
        `capítulo`.`ID` AS `capítuloID`,
        `capítulo`.`NO_CAPÍTULO` AS `capítuloNo`,
        `capítulo`.`TÍTULO` AS `título`,
        `capítulo`.`ID_LIBRO` AS `libro`,
        IFNULL(`capítulo`.`TEXTO`,'SinTexto') AS `body`,
        `capítulo`.`ARCHIVO_JSON` AS `archivo`
        FROM `fastreading_t_libros_capítulos` AS capítulo
        ";
    
    private $QLibro = "SELECT
        libro.`TÍTULO` AS `libroTítulo`,
        libro.`ID` AS `libroID`,
        libro.`PORTADA_URL` AS `libroPortada`,
        libro.`RESEÑA` AS `libroReseña`,
        libroIdioma.IDIOMA AS libroIdioma
        FROM `fastreading_t_libros` AS libro
        INNER JOIN fastreading_cat_idiomas AS libroIdioma ON libroIdioma.ID = libro.ID_IDIOMA
        ";
    
    public function __construct() {       
        $this->db = \Config\Database::connect();
    }
    
    /***********************************************************************************/
    // Sección de Libros
    /***********************************************************************************/
    
    function VLibroCU($IDlibro = null){
        if ($IDlibro) {
            $data = [
                'title' => "Cargando...",
                'libro' => $IDlibro,
                'método' => "U"
            ];
        }else{
            $data = [
                'title' => "Nuevo Libro",
                'libro' => $IDlibro,
                'método' => "C"
            ];
        }
        
        return $data;
    }
    
    public function JCatálogo($data){
        $respuesta = new E_Respuesta();
        $respuesta->status = true;

        $búsquedaPorIdioma = ($data['idioma']) ? " WHERE `libroIdioma`.ID = '$data[idioma]'" : "" ;
        $query = $this->db->query($this->QLibro . $búsquedaPorIdioma);

        $respuesta->data = $query->getResultArray();
        if ($respuesta->data) {
            $respuesta->msg = "Libros encontrados.";
            $respuesta->alert = "success";
        }else{
            $respuesta->msg = "No hay resultados.";
            $respuesta->alert = "info";
        }

        return $respuesta;
    }
    
    function JLibro($data){
        // Si viene un ID de libro, se busca ese libro. Si no, se buscan todos los libros.
        $respuesta = new E_Respuesta();
        $respuesta->status = true;

        $búsqueda = ($data['IDlibro']) ? " WHERE libro.ID = '$data[IDlibro]'" : "" ;
        $query = $this->db->query($this->QLibro . $búsqueda);

        $respuesta->data = $query->getRowArray();
        $respuesta->msg = "Libro encontrado.";
        $respuesta->alert = "success";
        
        return $respuesta;
    }
    
    function JLibroCU($data){
        $insert = [
            'TÍTULO' => $data['título'],
            'RESEÑA' => $data['reseña'],
            'ID_IDIOMA' => $data['idioma']
        ];
        
        $builder = $this->db->table('fastreading_t_libros');
        switch ($data['método']) {
            case null:
            case 'C':
                $f = $builder->insert($insert);
                break;
            case 'U':
                $builder->where('ID', $data['libro']);
                $f = $builder->update($insert);
                break;
            default:break;
        }
        
        if ($f) {
            $this->result['data']['lastID'] = $this->db->insertID();
            $this->result['msg'] = "Nuevo registro agregado.";
            $this->result['status'] = true;
        }else{
            $this->result['status'] = false;
            $this->result['error'] = $builder->getError();
        }
        return $this->result;   
    }


    function JRevisarFavoritos($data){
        $respuesta = new E_Respuesta();
        $respuesta->status = true;

        $builder = $this->db->table('fastreading_r_usuarios_libros_favoritos');
        $builder->select('ID_LIBRO');
        $builder->where('ID_LIBRO', $data['libroID']);
        $builder->where('ID_USUARIO', $data['usuarioID']);
        
        $f = $builder->get();
        $respuesta->data = $f->getRowArray();
        if ($respuesta->data) {
            $respuesta->msg = "En favoritos";
        }else{
            $respuesta->msg = "Agregar a favoritos";
        }

        return $respuesta;
    }

    // Libros favoritos de usuario
    function JFavoritos($data){
        $respuesta = new E_Respuesta();
        $ID_USUARIO = $data['usuarioID'];
        $búsqueda = "INNER JOIN fastreading_r_usuarios_libros_favoritos as favoritos ON favoritos.ID_LIBRO = libro.ID
            WHERE favoritos.ID_USUARIO = $ID_USUARIO";
        $query = $this->db->query($this->QLibro . $búsqueda);
        $respuesta->data = $query->getResultArray();
        $respuesta->status = true;
        if ($respuesta->data) {
            $respuesta->msg = "Libros encontrados.";
            $respuesta->alert = "success";
        }else{
            $respuesta->msg = "No se encontraron libros favoritos.";
        }
        return $respuesta;
    }

    function JFavoritosCD($data){
        $insert = [
            'ID_USUARIO' => $data['usuarioID'],
            'ID_LIBRO' => $data['libroID'],
        ];
        
        $builder = $this->db->table('fastreading_r_usuarios_libros_favoritos');
        switch ($data['método']) {
            case null:
            case 'C':
                $f = $builder->insert($insert);
                $this->result['msg'] = "Nuevo registro agregado.";
                $this->result['data']['lastID'] = $this->db->insertID();
                break;
            case 'D':
                $builder->where('ID_LIBRO', $data['libroID']);
                $builder->where('ID_USUARIO', $data['usuarioID']);
                $f = $builder->delete();
                $this->result['msg'] = "Registro eliminado.";
                break;
            default:break;
        }
        
        if ($f) {
            
            $this->result['status'] = true;
        }else{
            $this->result['status'] = false;
            $this->result['error'] = $builder->getError();
        }
        return $this->result;   
    }

    /***********************************************************************************/
    // Fin Sección de Libros
    /***********************************************************************************/
    
    /***********************************************************************************/
    // Sección de capítulos
    /***********************************************************************************/
    function VCapítuloCU($IDlibro = null, $IDcapítulo = null){
        if ($IDcapítulo) {
            $data = [
                'title' => "Cargando...",
                'libro' => $IDlibro,
                'capítulo' => $IDcapítulo,
                'método' => "U"
            ];
        }else{
            $data = [
                'title' => "Nuevo Libro",
                'libro' => $IDlibro,
                'capítulo' => null,
                'método' => "C"
            ];
        }
        
        return $data;
    }
    
    public function JCapítulos($data){
        $búsqueda = ($data['IDlibro']) ? " WHERE `capítulo`.ID_LIBRO = '$data[IDlibro]' ORDER BY NO_CAPÍTULO" : "" ;
        $query = $this->db->query($this->QCapítulosDeLibro . $búsqueda);
        return $query->getResultArray();
    }
    
    public function JCapítuloCU($data){
        $insert = [
            'TÍTULO' => $data['título'],
            'ID_LIBRO' => $data['libro'],
            'NO_CAPÍTULO' => $data['no-capítulo'],
            'TEXTO' => $data['cuerpo'],
        ];
        
        $builder = $this->db->table('fastreading_t_libros_capítulos');
        
        switch ($data['método']) {
            case null:
            case 'C':
                $f = $builder->insert($insert);
                break;
            case 'U':
                $builder->where('ID', $data['capítulo']);
                $f = $builder->update($insert);
                break;
            
            default:
                # code...
                break;
        }
        
        if ($f) {
            $this->result['data']['lastID'] = $this->db->insertID();
            $this->result['msg'] = "Registro exitoso";
            $this->result['status'] = true;
            $this->result['alert'] = "success";
        }else{
            $this->result['status'] = false;
            $this->result['error'] = $builder->getError();
        }
        
        return $this->result; 
    }
    
    public function JCapítuloDetalles($data){
        $búsqueda = ($data['capítulo']) ? " WHERE `capítulo`.ID = '$data[capítulo]'" : "" ;
        $query = $this->db->query($this->QCapítulosDeLibro . $búsqueda);
        $result = $query->getRowArray();
        return $result;
    }
    
    public function JCapítuloDetallesU($data){
        // Si hubo cambio en el título
        $builder = $this->db->table('t_libros_capítulos');
        $builder->where('ID', $data['capítulo']);
            
        
        $update  = [
            'TÍTULO' => $data['título'],
            'TEXTO' => $data['cuerpo']
        ];
        
        
        
        if ($builder->update($update)) {
            $this->result['data']['lastID'] = $this->db->insertID();
            $this->result['alert'] = "alert-success";
            $this->result['msg'] = "Registro actualizado.";
            $this->cambioF = true;
        }else{
            $this->result['status'] = false;
            $this->result['alert'] = "alert-info";
            $this->result['error'] = $builder->getError();
        }
        
        

        if (!$this->cambioF) {
            $this->result['msg'] = "No hubo cambios.";
            $this->result['alert'] = "alert-info";
        }
        
        return $this->result; 
    }
    
    /***********************************************************************************/
    // Fin Sección de capítulos
    /***********************************************************************************/
    
    
    
    
}