<?php

namespace Model;

use Model\ActiveRecord;

class Cotidiano_evaluacion extends ActiveRecord {
    protected static $tabla = 'cotidiano_evaluacion';
    protected static $columnasDB = ['id', 'modulo', 'periodo','indicador','valor','estudiante_id'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->modulo = $args['modulo'] ?? '';
        $this->periodo = $args['periodo'] ?? '';
        $this->indicador = $args['indicador'] ?? '';
        $this->valor = $args['valor'] ?? '';
        $this->estudiante_id = $args['estudiante_id'] ?? '';
    }
    
}
   