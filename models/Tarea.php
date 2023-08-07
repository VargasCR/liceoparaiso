<?php


namespace Model;

use Model\ActiveRecord;

class Tarea extends ActiveRecord {
    protected static $tabla = 'tarea';
    protected static $columnasDB = ['id', 'cant','modulo','periodo','totalPuntosTarea','totalPorcentajeTarea','evaluacion'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cant = $args['cant'] ?? 1;
        $this->modulo = $args['modulo'] ?? '';
        $this->periodo = $args['periodo'] ?? '';
        $this->totalPuntosTarea = $args['totalPuntosTarea'] ?? '';
        $this->totalPorcentajeTarea = $args['totalPorcentajeTarea'] ?? '';
        $this->evaluacion = $args['evaluacion'] ?? '';
    }
}
