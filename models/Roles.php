<?php

namespace Model;

class Roles extends ActiveRecord {
    protected static $tabla = 'roles';
    protected static $columnasDB = ['id', 'nombre', 'estatus', 'descripcion', 'creado_at', 'actualizado_at'];

    public $id;
    public $nombre;
    public $estatus;
    public $descripcion;
    public $creado_at;
    public $actualizado_at;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->estatus = $args['estatus'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->creado_at = $args['creado_at'] ?? date('Y-m-d H:i:s');
        $this->actualizado_at = $args['actualizado_at'] ?? date('Y-m-d H:i:s');
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['danger'][] = 'El nombre del rol es obligatorio';
        }
        if(strlen($this->nombre) > 255) {
            self::$alertas['danger'][] = 'El nombre del rol no puede tener más de 255 caracteres';
        }
        if(strlen($this->descripcion) > 500) {
            self::$alertas['danger'][] = 'La descripción del rol no puede tener más de 500 caracteres';
        }
        return self::$alertas;
    }

    // Método para obtener los permisos asociados a este rol
    public function permisos() {
        return Permiso::findAllBy('rol_id', $this->id);
    }

    public function guardar() {
        if(!$this->id) {
            $this->creado_at = date('Y-m-d H:i:s');
        }
        $this->actualizado_at = date('Y-m-d H:i:s');
        return parent::guardar();
    }

    public function usuarios() {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
    
    
}
