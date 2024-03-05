<?php

namespace App\Models;
use CodeIgniter\Model;

class M_Idiomas extends Model
{   
    
    private $QCatálogoDeIdiomas = "SELECT
	    idioma.ID AS 'id',
        idioma.IDIOMA AS `idioma`,
        idioma.HTML_ICON AS 'ícono'
        FROM fastreading_cat_idiomas AS idioma
        ";
    
    
    public function __construct() {       
        $this->db = \Config\Database::connect();
    }
    
    public function JCatálogo(){        
        $query = $this->db->query($this->QCatálogoDeIdiomas);
        return $query->getResultArray();
    }
    
    
}