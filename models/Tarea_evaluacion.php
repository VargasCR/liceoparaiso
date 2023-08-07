<?php


namespace Model;

use Model\ActiveRecord;

class Tarea_evaluacion extends ActiveRecord {
    protected static $tabla = 'tarea_evaluacion';
    protected static $columnasDB = ['id', 'estudiante','modulo','tareasPuntos','tareasPorcentaje','tareasNota','periodo','observaciones','indicador'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->estudiante = $args['estudiante'] ?? '';
        $this->modulo = $args['modulo'] ?? '';
        $this->tareasPuntos = $args['tareasPuntos'] ?? '';
        $this->tareasPorcentaje = $args['tareasPorcentaje'] ?? '';
        $this->tareasNota = $args['tareasNota'] ?? '';
        $this->periodo = $args['periodo'] ?? '';
        $this->observaciones = $args['observaciones'] ?? '';

        $this->indicador = $args['indicador'] ?? '';
    }
}
