<?php


namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord {
    protected static $tabla = 'proyecto';
    protected static $columnasDB = ['id','indicadores','modulo','periodo','porcentajeTotal'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->indicadores = $args['indicadores'] ?? 1;
        $this->modulo = $args['modulo'] ?? '';
        $this->periodo = $args['periodo'] ?? '';
        $this->porcentajeTotal = $args['porcentajeTotal'] ?? '0';
        
    }
}