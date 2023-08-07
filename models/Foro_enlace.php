<?php


namespace Model;

use Model\ActiveRecord;

class Foro_enlace extends ActiveRecord {
    protected static $tabla = 'foro_enlaces';
    protected static $columnasDB = ['id','foro_id','titulo','enlace','ind'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->foro_id = $args['foro_id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->enlace = $args['enlace'] ?? '';
        $this->ind = $args['ind'] ?? '';
        
    }
}
