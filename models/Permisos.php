<?php

namespace Model;

class Permisos extends ActiveRecord {
    // Definir la tabla asociada al modelo
    protected static $tabla = 'permisos';
    protected static $columnasDB = ['id', 'rol_id', 'nombre', 'descripcion', 'creado_at', 'actualizado_at'];

    public $id;
    public $rol_id;
    public $nombre;
    public $descripcion;
    public $creado_at;
    public $actualizado_at;

    // Constructor de la clase
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->rol_id = $args['rol_id'] ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->creado_at = $args['creado_at'] ?? '';
        $this->actualizado_at = $args['actualizado_at'] ?? '';
    }

    // Validación de los datos del permiso
    public function validar() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del permiso es obligatorio';
        }

        // Validación para asegurar que rol_id sea un entero positivo
        if (!$this->rol_id || !is_numeric($this->rol_id) || $this->rol_id <= 0) {
            $alertas['error'][] = 'Debes seleccionar un rol por permiso y este es obligatorio';
        }

        if (!$this->descripcion) {
            self::$alertas['error'][] = 'La descripción del permiso es obligatoria';
        }

        return self::$alertas;
    }

    // Método para asociar un permiso con un rol
    public function rol() {
        return Roles::find($this->rol_id);
    }

    // Sobreescribimos el método guardar para manejar automáticamente las fechas de creación y actualización
    public function guardar() {
        // Si es un nuevo registro, asigna la fecha de creación
        if (!$this->id) {
            $this->creado_at = date('Y-m-d H:i:s');
        }

        // En cualquier caso, asigna la fecha de actualización
        $this->actualizado_at = date('Y-m-d H:i:s');

        return parent::guardar();
    }

    // Sincronizar los atributos con datos de la base de datos
    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
