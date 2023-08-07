<?php


namespace Model;

use Model\ActiveRecord;

class Foro_items extends ActiveRecord {
    protected static $tabla = 'foro_items';
    protected static $columnasDB = ['id','foro_id','texto','ind','clase'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->foro_id = $args['foro_id'] ?? '';
        $this->texto = $args['texto'] ?? '';
        $this->ind = $args['ind'] ?? '';
        $this->clase = $args['clase'] ?? '';
        
    }
}
