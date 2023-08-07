<?php


namespace Model;

use Model\ActiveRecord;

class Ajuste extends ActiveRecord {
    protected static $tabla = 'ajustes';
    protected static $columnasDB = ['id', 'userid', 'searching'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->userid = $args['userid'] ?? null;
        $this->searching = $args['searching'] ?? null;
    }
    public static function visibilidadSearchingbar($id,$value) {
      

        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  "searching='".self::$db->escape_string($value)."'";
        $query .= " WHERE id = '" . self::$db->escape_string($id) . "' ";
        $query .= " LIMIT 1;"; 

                        // debuguear($query);

        $resultado = self::$db->query($query);
        return $resultado;
    }
   
}