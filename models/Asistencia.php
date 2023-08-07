<?php


namespace Model;

use Model\ActiveRecord;

class Asistencia extends ActiveRecord {
    protected static $tabla = 'asistencia';
    protected static $columnasDB = ['id', 'moduloID','totalAsistencia','totalIndicadores','periodo'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->moduloID = $args['moduloID'] ?? '';
        $this->totalAsistencia = $args['totalAsistencia'] ?? '';
        $this->totalIndicadores = $args['totalIndicadores'] ?? 1;
        $this->periodo = $args['periodo'] ?? 1;
      
   
    }
}
