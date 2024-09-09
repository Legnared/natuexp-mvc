<?php

namespace Model;

class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'foto', 'password', 'confirmado', 'token', 'perfil', 'fecha_creacion', 'fecha_modificacion', 'estatus', 'rol_id', 'direccion_id'];

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
    public $estatus;
    public $fecha_modificacion;
    public $rol_id;
    public $direccion_id; // Añadido

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
        $this->fecha_creacion = $args['fecha_creacion'] ?? date('Y-m-d H:i:s');
        $this->fecha_modificacion = $args['fecha_modificacion'] ?? date('Y-m-d H:i:s');
        $this->token = $args['token'] ?? '';
        $this->perfil = $args['perfil'] ?? 'usuario';
        $this->foto = $args['foto'] ?? '';
        $this->estatus = $args['estatus'] ?? 1;
        $this->rol_id = $args['rol_id'] ?? null;
        $this->direccion_id = isset($args['direccion_id']) ? (int) $args['direccion_id'] : null; // Inicialización como entero
    }

    // Método para sanitizar datos
    private function sanitize($data) {
        return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
    }
    

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacío';
        }
        return self::$alertas;
    }

    // Validación para cuentas nuevas
    public function validar_cuenta() {
        $alertas = [];
        
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El Teléfono es Obligatorio';
        }
         // Solo validar la contraseña si se ha proporcionado una nueva contraseña
        if (!empty($this->password)) {
            $alertas = array_merge($alertas, $this->validar_password());
        }
            return self::$alertas;
        }

    public function validar_password() {
        $alertas = [];
        
        // Validar que la contraseña no esté vacía
        if (!$this->password) {
            $alertas['error'][] = 'El Password no puede ir vacío';
        }
    
        // Validar longitud de la contraseña
        if (strlen($this->password) < 6) {
            $alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
    
        // Validar que las contraseñas coincidan
        if ($this->password !== $this->password2) {
            $alertas['error'][] = 'Los passwords son diferentes';
        }
        
        return $alertas;
    }
    


    // Validar Email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    // Validar Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacío';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Validar nuevo password
    public function nuevo_password() : array {
        self::$alertas = []; // Limpia las alertas para evitar mensajes duplicados
        
        // Verifica si el campo password_actual está presente en el formulario
        if (isset($this->password_actual) && empty($this->password_actual)) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacío';
        }
        
        if (empty($this->password_nuevo)) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacío';
        }
        
        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        
        return self::$alertas;
    }



    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password);
    }

    // Hashear el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }



    // Cambiar la contraseña
    public function resetPassword($nuevo_password) {
        if (!$nuevo_password || strlen($nuevo_password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
            return false;
        }

        $this->password = password_hash($nuevo_password, PASSWORD_BCRYPT);
        $this->token = ''; // Opcional
        $this->fecha_modificacion = date('Y-m-d H:i:s');

        return $this->guardar();
    }

    
    



    // Generar un Token
    public function crearToken() : void {
        $this->token = bin2hex(random_bytes(32));
    }

    
    
    

    // Validar perfil
    public function validar_perfil() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        return self::$alertas;
    }


     // Relación con Direccion
    public function direccion() {
        return $this->belongsTO(Direccion::class, 'direccion_id');
    }

    // Método para obtener las direcciones asociadas al usuario
    public function obtenerDirecciones() {
        return Direccion::where('usuario_id', $this->id);
    }

    public function obtenerRol() {
        if ($this->rol_id) {
            $rol = Roles::find($this->rol_id);
            return $rol ? $rol->nombre : 'Sin rol';
        }
        return 'Sin rol';
    }

    public function direcciones() {
        return Direccion::findByUsuarioId($this->id);
    }
    

    // Crear un nuevo usuario
    public function crear() {
        $this->fecha_creacion = date('Y-m-d H:i:s'); // Establece la fecha de creación solo al crear un nuevo usuario
        return parent::crear();
    }

    public function getError() {
        return $this->error; // Ajusta según cómo manejes los errores en tus modelos
    }

    public function guardar() {
        // Sanitizar atributos
        $atributos = $this->sanitizarAtributos();
    
        if (isset($this->id) && $this->id !== null) {
            // Preparar columnas y valores para UPDATE
            $valores = [];
            foreach ($atributos as $columna => $valor) {
                $valores[] = "{$columna} = ?";
            }
            $valores = implode(', ', $valores);
    
            // Crear consulta SQL para UPDATE
            $consulta = "UPDATE " . static::$tabla . " SET $valores WHERE id = ?";
    
            // Preparar consulta
            $stmt = self::$db->prepare($consulta);
            if (!$stmt) {
                throw new \Exception('Error en la preparación de la consulta: ' . self::$db->error);
            }
    
            // Vincular parámetros
            $tipos = '';
            foreach ($atributos as $valor) {
                $tipos .= is_int($valor) ? 'i' : 's';
            }
            $tipos .= 'i'; // Para el ID
    
            // Crear un array de valores que incluye los atributos y el ID
            $params = array_merge(array_values($atributos), [$this->id]);
    
            // Vincular parámetros usando call_user_func_array
            $stmt->bind_param($tipos, ...$params);
    
        } else {
            // Preparar columnas y valores para INSERT
            $columnas = implode(', ', array_keys($atributos));
            $valores = implode(', ', array_fill(0, count($atributos), '?'));
    
            // Crear consulta SQL para INSERT
            $consulta = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($valores)";
    
            // Preparar consulta
            $stmt = self::$db->prepare($consulta);
            if (!$stmt) {
                throw new \Exception('Error en la preparación de la consulta: ' . self::$db->error);
            }
    
            // Vincular parámetros
            $tipos = '';
            foreach ($atributos as $valor) {
                $tipos .= is_int($valor) ? 'i' : 's';
            }
            $stmt->bind_param($tipos, ...array_values($atributos));
        }
    
        // Ejecutar consulta
        $resultado = $stmt->execute();
    
        // Verificar si la ejecución fue exitosa
        if (!$resultado) {
            throw new \Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }
    
        // Cerrar el statement
        $stmt->close();
    
        return $resultado;
    }
    
    
    
   public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $this->sanitize($value);
            }
        }
    }
    

    public function rol() {
        return $this->belongsTo(Roles::class, 'rol_id');
    }
    
    
}
