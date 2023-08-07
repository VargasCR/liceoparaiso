<?php


namespace Model;

use Model\ActiveRecord;

class Profesor extends ActiveRecord {
    protected static $tabla = 'profesores';
    protected static $columnasDB = ['id', 'dni', 'nombre','apellido','materias'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->dni = $args['dni'] ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->materias = $args['materias'] ?? '';
        
    }

    public function validarProfesor() {
        if(!$this->dni) {
            self::$alertas['error'][] = 'El DNI del Estudiante es Obligatorio';
        }
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Estudiante es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido del Estudiante es Obligatorio';
        }
        if(!$this->materias) {
            self::$alertas['error'][] = 'Seleccione una materia';
        }

        return self::$alertas;
    }
    

    }

    
