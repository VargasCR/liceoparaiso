<?php


namespace Model;

use Model\ActiveRecord;

class Modulo extends ActiveRecord {
    protected static $tabla = 'modulos';
    protected static $columnasDB = ['id', 'grupoID', 'profesorID', 'nombre','aula'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->grupoID = $args['grupoID'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->profesorID = $args['profesorID'] ?? '';
        $this->aula = $args['aula'] ?? '';
    }

    public function validar($alertas = '') {
        if (!$this->nombre) {
            $alertas['error'][] = 'Agregue los nombres de los módulos';
        
        }
        if (!$this->profesorID || $this->profesorID < 0) {
            $alertas['error'][] = 'Seleccione los profesores de los módulos';
        
        }
        if (!is_numeric($this->aula)) {
            $alertas['error'][] = 'El aula de los módulos debe ser un número';
          
        }
        
    
        return $alertas;
    }
    
}