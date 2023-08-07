<?php


namespace Model;

use Model\ActiveRecord;

class Proyecto_observacion extends ActiveRecord {
    protected static $tabla = 'proyecto_observacion';
    protected static $columnasDB = ['id', 'valor','indicador','estudiante','modulo','proyecto'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
   
        $this->indicador = $args['indicador'] ?? '';
        

        $this->valor = $args['valor'] ?? '';
        $this->estudiante = $args['estudiante'] ?? '';
        $this->modulo = $args['modulo'] ?? '';
        $this->proyecto = $args['proyecto'] ?? '';
        
        
    }
}