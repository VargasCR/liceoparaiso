<?php


namespace Model;

use Model\ActiveRecord;

class Asistencia_beca extends ActiveRecord {
    protected static $tabla = 'asistencia_beca';
    protected static $columnasDB = ['id', 'estudianteID', 'fecha'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->estudianteID = $args['estudianteID'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
    }
}