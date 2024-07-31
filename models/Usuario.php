<?php

namespace Model;

class Usuario extends ActiveRecord {
    
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email',  'telefono', 'foto', 'password', 'confirmado', 'token', 'perfil', 'fecha_creacion', 'fecha_modificacion' ,'estado'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $password;
    public $password2;
    public $password_nuevo;
    public $password_actual;
    public $confirmado;
    public $fecha_creacion;
    public $token;
    public $perfil;
    public $foto;
    public $estado;
    public $fecha_modificacion;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $this->sanitize($args['nombre'] ?? '');
        $this->apellido = $this->sanitize($args['apellido'] ?? '');
        $this->email = $this->sanitize($args['email'] ?? '');
        $this->telefono = $this->sanitize($args['telefono'] ?? '');
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->fecha_creacion = $args['fecha_creacion'] ?? 'NOW()';
        $this->token = $args['token'] ?? '';
        $this->perfil = $args['perfil'] ?? 'usuario';
        $this->foto = $args['foto'] ?? '';
        $this->estado = $args['estado'] ?? 1;
        $this->fecha_modificacion = $args['fecha_modificacion'] ?? 'NOW()';
    }
    
    // Método para sanitizar datos
    private function sanitize($data) {
        return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['danger'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['danger'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alertas['danger'][] = 'El Password no puede ir vacio';
        }
        return self::$alertas;
    }
    


    // Validación para cuentas nuevas
    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$alertas['danger'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['danger'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['danger'][] = 'El Email es Obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['danger'][] = 'El Telefóno es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['danger'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['danger'][] = 'El password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['danger'][] = 'Los password son diferentes';
        }
        return self::$alertas;
    }

    // Valida un email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['danger'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['danger'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    
    // Valida el Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['danger'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['danger'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['danger'][] = 'El Password Actual no puede ir vacio';
        }
        if(!$this->password_nuevo) {
            self::$alertas['danger'][] = 'El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['danger'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //validamos el perfil
    public function validar_perfil() {
        if (!$this->nombre) {
            self::$alertas['danger'][] = 'El nombre es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['danger'][] = 'El email es Obligatorio';
        }
        return self::$alertas;
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}