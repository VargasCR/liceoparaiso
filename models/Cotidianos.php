<?php


namespace Model;

use Model\ActiveRecord;

class Cotidiano extends ActiveRecord {
    protected static $tabla = 'cotidianos';
    protected static $columnasDB = ['id', 'estudianteID', 'cotidianoID','totalCotidiano'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cotidianoID = $args['moduloID'] ?? '';
        $this->total = $args['total'] ?? '';
      
   
    }
}
