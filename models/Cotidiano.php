<?php


namespace Model;

use Model\ActiveRecord;

class Cotidiano extends ActiveRecord {
    protected static $tabla = 'cotidiano';
    protected static $columnasDB = ['id', 'moduloID','totalCotidiano','totalIndicadores','periodo'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->moduloID = $args['moduloID'] ?? '';
        $this->totalCotidiano = $args['totalCotidiano'] ?? '';
        $this->totalIndicadores = $args['totalIndicadores'] ?? 1;
        $this->periodo = $args['periodo'] ?? 1;
      
   
    }
}
