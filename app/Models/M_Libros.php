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
        `capítulo`.`TÍTULO` AS `título`,
        `capítulo`.`ID_LIBRO` AS `libro`,
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
    
    function JNuevo($data){
        $insert = [
            'TÍTULO' => $data['título'],
            'RESEÑA' => $data['reseña'],
            'ID_IDIOMA' => $data['idioma']
        ];
        
        $builder = $this->db->table('t_libros');
        
        if ($builder->insert($insert)) {
            $this->result['data']['lastID'] = $this->db->insertID();
            $this->result['msg'] = "Nuevo registro agregado.";
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
    public function JCapítulos($data){
        $búsqueda = ($data['IDlibro']) ? " WHERE `capítulo`.ID_LIBRO = '$data[IDlibro]'" : "" ;
        $query = $this->db->query($this->QCapítulosDeLibro . $búsqueda);
        return $query->getResultArray();
    }
    
    public function JCapítulosC($data){
        $insert = [
            'TÍTULO' => $data['nuevo-título'],
            'ID_LIBRO' => $data['IDlibro']
        ];
        $file = microtime();
        $file = str_replace([" ", "."], "_", $file).".json";
        $this->result['data']['file'] = $file;
        $filePath = './libros_json/' . $file;
        if (fopen("$filePath", "w")) {
            $insert["ARCHIVO_JSON"] = $file;
            $builder = $this->db->table('t_libros_capítulos');
            
            if ($builder->insert($insert)) {
                $this->result['data']['lastID'] = $this->db->insertID();
                $this->result['msg'] = "Nuevo registro agregado.";
                // $this->result['status'] = true;
            }else{
                $this->result['status'] = false;
                $this->result['error'] = $builder->getError();
            }
        }
        return $this->result; 
    }
    
    public function JCapítuloDetalles($data){
        $búsqueda = ($data['capítulo']) ? " WHERE `capítulo`.ID = '$data[capítulo]'" : "" ;
        $query = $this->db->query($this->QCapítulosDeLibro . $búsqueda);
        $result = $query->getRowArray();
        if (isset($data['f']) && $data['f']) {
            $body = json_decode(file_get_contents( base_url(). '/libros_json/'.$result['archivo']));
            if ($body != null) {
                $result['body'] = $body->body;
            }else{
                $result['body'] = "Sin texto.";
            }
        }
        return $result;
    }
    
    public function JCapítuloDetallesU($data){
        // Si hubo cambio en el título
        $builder = $this->db->table('t_libros_capítulos');
        $builder->where('ID', $data['capítulo']);
            
        if ( $data['título-f']) {
            $update  = ['TÍTULO' => $data['título']];
            
            
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
        }
        
        // Si hubo cambio en el contenido del capítulo
        if ( $data['cuerpo-f']) {
            
            $builder->select('ARCHIVO_JSON');
            $querySelect = $builder->get()->getRow();
            if (!empty($querySelect)) {
                helper('filesystem');
                $file = new \CodeIgniter\Files\File('./libros_json/' . $querySelect->ARCHIVO_JSON);
                $filePath = './libros_json/' . $querySelect->ARCHIVO_JSON;
                $writeToFile = $file->openFile('w');
                write_file($filePath, json_encode(['body' => $data['cuerpo']]));
                
                $this->result['data']['result'] = [$querySelect, $file->getSize()];
                $this->result['alert'] = "alert-success";
                $this->result['msg'] = "Registro actualizado.";
                $this->cambioF = true;
            }
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