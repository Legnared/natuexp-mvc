<?php

namespace Model;

class Seta extends ActiveRecord {

    protected static $tabla = 'setas';
    protected static $columnasDB = ['id', 'nombre', 'descripcion', 'imagen', 'tags', 'especie_id'];

    public $id;
    public $nombre;
    public $descripcion;
    public $imagen;
    public $tags;
    public $especie_id;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->especie_id = $args['especie_id'] ?? '';
    }

    
    // Mensajes de validación para la creación de un evento
        public function validar() {
            if(!$this->nombre) {
                self::$alertas['error'][] = 'El Nombre es Obligatorio';
            }
            if(!$this->descripcion) {
                self::$alertas['error'][] = 'La descripción es Obligatoria';
            }
            
            if(!$this->imagen) {
                self::$alertas['error'][] = 'La imagen es Obligatoria';
            }
            if(!$this->tags) {
                self::$alertas['error'][] = 'El campo tags es Obligatoria';
            }
            if(!$this->especie_id  || !filter_var($this->especie_id, FILTER_VALIDATE_INT)) {
                self::$alertas['error'][] = 'Elige una Categoría';
            }


            return self::$alertas;
        }
}