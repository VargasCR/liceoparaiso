<?php

namespace Model;

use Model\ActiveRecord;

class Asistencia_evaluacion extends ActiveRecord {
    protected static $tabla = 'asistencia_evaluacion';
    protected static $columnasDB = ['id', 'modulo', 'periodo','indicador','valor','estudiante_id','date'];

    public function __construct($args = [])
    {   
        $this->id = $args['id'] ?? null;
        $this->modulo = $args['modulo'] ?? '';
        $this->periodo = $args['periodo'] ?? '';
        $this->indicador = $args['indicador'] ?? '';
        $this->valor = $args['valor'] ?? '';
        $this->estudiante_id = $args['estudiante_id'] ?? '';
        $this->date = $args['date'] ?? '';
    }

    public static function findDate($arrayOriginal) {
        
        // Arrays para almacenar las fechas únicas de cada periodo
$fechasPeriodo1 = [];
$fechasPeriodo2 = [];
$ultimo_indicador1 = [];
$ultimo_indicador2 = [];

// Recorrer el array original
foreach ($arrayOriginal as $objeto) {
    // Obtener la fecha y el periodo del objeto
    $fecha = $objeto->date;
    $periodo = $objeto->periodo;
    $indicador = $objeto->indicador;

    // Verificar el periodo y agregar la fecha al array correspondiente
    if ($periodo == 1) {
        if (!in_array($indicador, $ultimo_indicador1)) {
            $fechasPeriodo1[] = $fecha;
            $ultimo_indicador1[] = $indicador;
        }
    } elseif ($periodo == 2) {
        if (!in_array($indicador, $ultimo_indicador2)) {
            $fechasPeriodo2[] = $fecha;
            $ultimo_indicador2[] = $indicador;
        }
    }
}
$fechas[] = $fechasPeriodo1;
$fechas[] = $fechasPeriodo2;
//debuguear($fechas);
return $fechas;

    }
    
}
   