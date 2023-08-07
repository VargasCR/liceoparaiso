<?php


namespace Model;

use Model\ActiveRecord;

class Foro_images extends ActiveRecord {
    protected static $tabla = 'foro_imagenes';
    protected static $columnasDB = ['id','url','height','width','ind','foro_id','clase'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->foro_id = $args['foro_id'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->height = $args['height'] ?? '100';
        $this->width = $args['width'] ?? '100';
        $this->clase = $args['clase'] ?? '';
        $this->ind = $args['ind'] ?? '';
        
    }
}
