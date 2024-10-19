<?php

namespace Model;

class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';  
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];
    
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = "Debes agregar un titulo";
        }

        if(!$this->precio) {
            self::$errores[] = "Debes agregar un precio";
        }

        if(!$this->descripcion) {
            $errores[] = "Debes agregar un descripcion";
        }

        if(!$this->habitaciones) {
            self::$errores[] = "Debes agregar numero de habitaciones";
        }

        if(!$this->wc) {
            self::$errores[] = "Debes agregar numero de baños";
        }

        if(!$this->estacionamiento) {
            self::$errores[] = "Debes agregar numero de lugares de estacionamiento";
        }

        if(!$this->vendedores_id) {
            self::$errores[] = "Debes seleccionar el vendedor";
        }

        if(!$this->imagen) {
            self::$errores[] = "La imagen de la propiedad es obligatoria";
        }

        return self::$errores;
    }
}