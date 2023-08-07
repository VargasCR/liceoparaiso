<?php


namespace Model;

use Model\ActiveRecord;

class Proyecto_indicador extends ActiveRecord {
    protected static $tabla = 'proyecto_indicador';
    protected static $columnasDB = ['id', 'valor','proyecto','modulo','indicador'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        
        $this->proyecto = $args['proyecto'] ?? '';
        
        $this->valor = $args['valor'] ?? '';
        $this->modulo = $args['modulo'] ?? '';
        $this->indicador = $args['indicador'] ?? '';
        
        
    }
}