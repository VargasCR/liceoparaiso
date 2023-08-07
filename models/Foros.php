<?php


namespace Model;

use Model\ActiveRecord;

class Foros extends ActiveRecord {
    protected static $tabla = 'foros';
    protected static $columnasDB = ['id','profesor','year','periodo','titulo','categoria','icon_img'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->profesor = $args['profesor'] ?? '';
        $this->year = $args['year'] ?? '';
        $this->periodo = $args['periodo'] ?? '1';
        $this->titulo = $args['titulo'] ?? '';
        $this->categoria = $args['categoria'] ?? '';
        $this->icon_img = $args['icon_img'] ?? '';
    }
    public static function findForo($phrase) {
        if ($phrase == '') {
            $query = "SELECT * FROM " . static::$tabla;
        } else {
            $query = "SELECT * FROM " . static::$tabla . " WHERE (titulo LIKE '%${phrase}%' OR categoria LIKE '%${phrase}%')";
        };
        
        $resultado = self::consultarSQL($query);
        //debuguear($resultado);
        return $resultado;
    }
}
