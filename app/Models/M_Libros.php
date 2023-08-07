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
    
    private $QCatálogoDeLibros = "SELECT
	    libroIdioma.IDIOMA AS idioma,
        libro.`TÍTULO` AS `título`,
        libro.ID AS 'libroID'
        FROM t_libros AS libro
        INNER JOIN cat_idiomas AS libroIdioma ON libroIdioma.ID = libro.ID_IDIOMA
        ";
    
    private $QCapítulosDeLibro = "SELECT
        `capítulo`.`ID` AS `capítuloID`,
        `capítulo`.`NO_CAPÍTULO` AS `capítuloNo`,
        `capítulo`.`TÍTULO` AS `título`,
        `capítulo`.`ID_LIBRO` AS `libro`,
        IFNULL(`capítulo`.`TEXTO`,'SinTexto') AS `body`,
        `capítulo`.`ARCHIVO_JSON` AS `archivo`
        FROM `t_libros_capítulos` AS capítulo
        ";
    
    private $QLibro = "SELECT
        libro.`TÍTULO` AS `título`,
        libro.`RESEÑA` AS `reseña`,
        libroIdioma.IDIOMA AS idioma
        FROM `t_libros` AS libro
        INNER JOIN cat_idiomas AS libroIdioma ON libroIdioma.ID = libro.ID_IDIOMA
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
        $búsquedaPorIdioma = ($data['idioma']) ? " WHERE `libroIdioma`.ID = '$data[idioma]'" : "" ;
        $query = $this->db->query($this->QCatálogoDeLibros . $búsquedaPorIdioma);
        return $query->getResultArray();
    }
    
    function JLibro($data){
        $búsqueda = ($data['IDlibro']) ? " WHERE libro.ID = '$data[IDlibro]'" : "" ;
        $query = $this->db->query($this->QLibro . $búsqueda);
        return $query->getRowArray();
    }
    
    function JLibroCU($data){
        $insert = [
            'TÍTULO' => $data['título'],
            'RESEÑA' => $data['reseña'],
            'ID_IDIOMA' => $data['idioma']
        ];
        
        $builder = $this->db->table('t_libros');
        switch ($data['método']) {
            case null:
            case 'C':
                $f = $builder->insert($insert);
                break;
            case 'U':
                $builder->where('ID', $data['libro']);
                $f = $builder->update($insert);
                break;
            
            default:
                # code...
                break;
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
        // Depreciado; generar nombre de archivo para capítulos
        // $file = microtime();
        // $file = str_replace([" ", "."], "_", $file).".json";
        // $this->result['data']['file'] = $file;
        // $insert["ARCHIVO_JSON"] = $file;
        
        $builder = $this->db->table('t_libros_capítulos');
        
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
        // REMOVIDO PARA AHCER CAMBIO A USO EXLUSIVO DE BD
        // if (isset($data['f']) && $data['f']) {
        //     helper('filesystem');
        //     $file = new \CodeIgniter\Files\File('./libros_json/' . $result['archivo']);
        //     $filePath = './libros_json/' . $result['archivo'];
        //     $readFile = $file->openFile('r');
        //     $body = json_decode($readFile);
        //     if ($body != null) {
        //         $result['body'] = $body->body;
        //     }else{
        //         $result['body'] = "Sin texto.";
        //     }
        // }
        return $result;
    }
    
    public function JCapítuloDetallesU($data){
        // Si hubo cambio en el título
        $builder = $this->db->table('t_libros_capítulos');
        $builder->where('ID', $data['capítulo']);
            
        // if ( $data['título-f']) {
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
        // }
        
        // REMOVIDO PARA AHCER CAMBIO A USO EXLUSIVO DE BD
        // Si hubo cambio en el contenido del capítulo
        // if ( $data['cuerpo-f']) {
            
        //     $builder->select('ARCHIVO_JSON');
        //     $querySelect = $builder->get()->getRow();
        //     if (!empty($querySelect)) {
        //         helper('filesystem');
        //         $file = new \CodeIgniter\Files\File('./libros_json/' . $querySelect->ARCHIVO_JSON);
        //         $filePath = './libros_json/' . $querySelect->ARCHIVO_JSON;
        //         $writeToFile = $file->openFile('w');
        //         write_file($filePath, json_encode(['body' => $data['cuerpo']]));
                
        //         $this->result['data']['result'] = [$querySelect, $file->getSize()];
        //         $this->result['alert'] = "alert-success";
        //         $this->result['msg'] = "Registro actualizado.";
        //         $this->cambioF = true;
        //     }
        // }
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