<?php


namespace Model;

use Model\ActiveRecord;

class Noticias extends ActiveRecord {
    protected static $tabla = 'noticias';
    protected static $columnasDB = ['id', 'titulo', 'descripcion','fecha'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->fecha = date('Y-m-d');;
    }
}