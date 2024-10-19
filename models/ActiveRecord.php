<?php

namespace Model;

class ActiveRecord {
    // BASE DE DATOS
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // ERRORES
    protected static $errores = [];

    // DEFINIR CONEXION A DB
    public static function setDB($database) {
        self::$db = $database;
    }

    public function guardar() {
        if(!is_null($this->id)) {
            // ACTUALIZANDO REGISTRO
            $this->actualizar();
        }
        else {
            // CREANDO REGISTRO
            $this->crear();
        }
    }

    public function actualizar() {
        // SANITIZAR DATOS
        $atributos = $this->sanitizarDatos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        // debuguear(join(', ', $valores));
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);
        
        if($resultado) {
            // REDIRECCIONAR AL USUARIO
            header('Location: /admin?resultado=2');
        }
        
    }

    public function crear() {

        // SANITIZAR DATOS
        $atributos = $this->sanitizarDatos();
        // debuguear(array_keys($atributos));
        // $string = join(', ', array_values($atributos));
        // debuguear($string);

        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .=  join(', ', array_keys($atributos));
        $query .= " ) VALUES ( '";
        $query .=  join("', '", array_values($atributos));
        $query .= "' )";

        $resultado = self::$db->query($query);
        
        // MENSAJE DE EXITO
        if($resultado) {
            // REDIRECCIONAR AL USUARIO
            header('Location: /admin?resultado=1');
        }
    }

    // ELIMINAR REGISTRO
    public function eliminar() {
        // Eliminar registro
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    // IDENTIFICAR Y UNIR ATRIBUTOS DE DB
    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;

    }

    // SUBIDA DE ARCHIVOS
    public function setImagen($imagen) {

        // ELIMINA LA IMAGEN PREVIA (SI NO HAY ID SE ESTA CREANDO, SI HAY SE ESTA ACTUALIZANDO)
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }

        // ASIGNAR AL ATRIBUTO NOMBRE DE IMAGEN
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // ELIMINAR ARCHIVO
    public function borrarImagen() {
        // COMPROBAR SI EXISTE EL ARCHIVO
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // VALIDACION
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {      
        static::$errores = [];

        return static::$errores;
    }

    // LISTA TODAS LAS PROPIEDADES
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // OBTIENE DETERMINADO NUMERO DE REGISTROS
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // BUSCA REGISTRO POR SU ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        // CONSULTAR DB
        $resultado = self::$db->query($query);

        // ITERAR RESULTADOS
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        // debuguear($array);

        // LIBERAR MEMORIA
        $resultado->free();

        // RETORNAR RESULTADOS
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if( property_exists( $objeto, $key ) ) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // SINCRONIZA OBJETO EN MEMORIA CON CAMBIOS REALIZADOS POR EL USUARIO
    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}

?>