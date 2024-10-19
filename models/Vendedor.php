<?php

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar()
    {
        if(!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
        }

        if(!$this->apellido) {
            self::$errores[] = "El apellido es obligatorio";
        }

        if(!$this->telefono) {
            self::$errores[] = "Debes agregar un telefono";
        }

        // EXPRESION REGULAR que busca que no haya caracteres extranios
        if(!preg_match( ('/[0-9]{10}/'), $this->telefono )) {
            self::$errores[] = "Formato de telefono no valido";
        }

        return self::$errores;
    }

}


?>