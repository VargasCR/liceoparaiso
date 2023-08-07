<?php
namespace Model;
class ActiveRecord {
    
    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }
    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }
    public static function findLast($column, $value) {
        $query = "SELECT MAX(id) as id FROM " . static::$tabla . " WHERE $column = $value LIMIT 1";
        //debuguear($query);
        $result = self::consultarSQL($query);
        
        return array_shift( $result ) ;
    }
    public static function findLastForum() {
        $query = "SELECT MAX(id) as id FROM " . static::$tabla;
        //debuguear($query);
        $result = self::consultarSQL($query);
        
        return $result;
    }
    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registro
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }
// Busqueda Where con Columna 
public static function findStudentIN($valor) {
    $query = "SELECT * FROM " . static::$tabla . " WHERE id IN (${valor})";
    $resultado = self::consultarSQL($query);
    return $resultado;
}

public static function findStudent($valor,$seccion) {
    if (empty($seccion)) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE nombre LIKE '%${valor}%' OR apellido LIKE '%${valor}%' OR dni LIKE '%${valor}%';";
    } elseif (empty($valor) && !empty($seccion)) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE seccion = '${seccion}';";
    } else {
        $query = "SELECT * FROM " . static::$tabla . " WHERE (nombre LIKE '%${valor}%' OR apellido LIKE '%${valor}%' OR dni LIKE '%${valor}%') AND seccion = '${seccion}';";
    };
    
    $resultado = self::consultarSQL($query);
    return $resultado;
}
    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
       // debuguear(array_shift( $resultado ));
        return array_shift( $resultado );
    }
    public static function findGroup($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function allexcept($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} != '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function encontrarAsistencia($desde, $hasta) {
        $query = "SELECT * FROM asistencia_beca WHERE fecha >= '${desde}' AND fecha <= '${hasta}'";
      //  debuguear($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca todos los registros que pertenecen a un ID
    public static function belongsTo($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // SQL para Consultas Avanzadas.
    public static function SQL($consulta) {
        $query = $consulta;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "') ";
        //debuguear($query);
        // Resultado de la consulta
        $resultado = self::$db->query($query);

        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

                        // debuguear($query);

        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar_seleccionados($id) {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id IN (" .$id. ")";
        $resultado = self::$db->query($query);
        return $resultado;
    }
    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar_todos() {
        $query = "DELETE FROM "  . static::$tabla;
        $resultado = self::$db->query($query);
        return $resultado;
    }
    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }



    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }
    

    public static function where_AND_AND($columna,$valor,$columna_1,$valor_1,$columna_2,$valor_2) {
        $query = "SELECT * FROM ". static::$tabla . " WHERE ${columna} = '${valor}' AND ${columna_1} = '${valor_1}' AND ${columna_2} = '${valor_2}'";
        
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public function where_AND_AND_AND_AND($columna,$valor,$columna_1,$valor_1,$columna_2,$valor_2,$columna_3,$valor_3) {
        $query = "SELECT * FROM ". static::$tabla . " WHERE ${columna} = '${valor}' AND ${columna_1} = '${valor_1}' AND ${columna_2} = '${valor_2}' AND ${columna_3} = '${valor_3}'";
        //debuguear($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function where_AND($columna,$valor,$columna_1,$valor_1) {
        $query = "SELECT * FROM ". static::$tabla . " WHERE ${columna} = '${valor}' AND ${columna_1} = '${valor_1}'";
        
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}