<?php

namespace Model;

class Contacto extends ActiveRecord {

    protected static $tabla = 'contacto';
    protected static $columnasDB = ['id', 'nombre', 'email', 'asunto', 'mensaje', 'creado'];

    public $id;
    public $nombre;
    public $email;
    public $asunto;
    public $mensaje;
    public $creado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->asunto = $args['asunto'] ?? '';
        $this->mensaje = $args['mensaje'] ?? '';
        $this->creado = $args['creado'] ?? '';
    }

    public function validar() {
        self::$alertas = []; // Aseguramos que las alertas están vacías

        if (!$this->nombre) {
            self::$alertas['danger'][] = 'El nombre es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['danger'][] = 'El email es obligatorio';
        }
        if (!$this->asunto) {
            self::$alertas['danger'][] = 'El asunto es obligatorio';
        }
        if (!$this->mensaje) {
            self::$alertas['danger'][] = 'El mensaje es obligatorio';
        }

        return self::$alertas;
    }

  
}
?>
