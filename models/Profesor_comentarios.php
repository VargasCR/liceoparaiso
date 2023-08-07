<?php


namespace Model;

use Model\ActiveRecord;

class Profesor_comentarios extends ActiveRecord {
    protected static $tabla = 'profesor_comentarios';
    protected static $columnasDB = ['id', 'estudiante', 'modulo','periodo','comentario'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->estudiante = $args['estudiante'] ?? null;
        $this->modulo = $args['modulo'] ?? '';
        $this->periodo = $args['periodo'] ?? '';
        $this->comentario = $args['comentario'] ?? '';
        
    }
}
