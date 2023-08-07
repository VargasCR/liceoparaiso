<?php


namespace Model;

use Model\ActiveRecord;

class Horario extends ActiveRecord {
    protected static $tabla = 'horarios';
    protected static $columnasDB = ['id', 'grupoID', 'leccion','moduleID'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->grupoID = $args['grupoID'] ?? '';
        $this->leccion = $args['leccion'] ?? '';
        $this->moduleID = $args['moduleID'] ?? '';
   
    }
}
