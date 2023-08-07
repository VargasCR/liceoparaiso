<?php


namespace Model;

use Model\ActiveRecord;

class Grupo extends ActiveRecord {
    protected static $tabla = 'grupos';
    protected static $columnasDB = ['id', 'grado', 'seccion'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->grado = $args['grado'] ?? '';
        $this->seccion = $args['seccion'] ?? '';
    }
    public function validar_grupo() {
        if (!$this->grado) {
            self::$alertas['error'][] = 'Agregue el grado';
        }
        if (!$this->seccion) {
            self::$alertas['error'][] = 'Agregue la sección';
        }
        if (!is_numeric($this->seccion)) {
            self::$alertas['error'][] = 'La sección debe ser un número';
        }
        if (!is_numeric($this->grado)) {
            self::$alertas['error'][] = 'El grado debe ser un número';
        }
        return self::$alertas;
    }
    
    
}