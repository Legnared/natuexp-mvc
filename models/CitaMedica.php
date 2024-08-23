<?php
namespace Model;

class CitaMedica extends ActiveRecord {

    protected static $tabla = 'citas_medica';
    protected static $columnasDB = [
        'id', 'nombre', 'apellidos', 'fecha_nacimiento', 'edad', 'sexo', 'telefono', 'email',
        'direccion', 'fecha_hora', 'motivo', 'tipo_consulta', 'aceptar_terminos'
    ];

    public $id;
    public $nombre;
    public $apellidos;
    public $fecha_nacimiento;
    public $edad;
    public $sexo;
    public $telefono;
    public $email;
    public $direccion;
    public $fecha_hora;
    public $motivo;
    public $tipo_consulta;
    public $aceptar_terminos;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->fecha_nacimiento = $args['fecha_nacimiento'] ?? '';
        $this->edad = $args['edad'] ?? null;
        $this->sexo = $args['sexo'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->fecha_hora = $args['fecha_hora'] ?? '';
        $this->motivo = $args['motivo'] ?? '';
        $this->tipo_consulta = $args['tipo_consulta'] ?? '';
        $this->aceptar_terminos = $args['aceptar_terminos'] ?? false;
    }

    public function validar() {
        $alertas = [];

        if (!$this->nombre) {
            $alertas['danger'][] = 'El nombre(s)  es/son obligatorio(s)';
        }
        if (!$this->apellidos) {
            $alertas['danger'][] = 'El(Los) Apllido(s)  es/son obligatorio(s)';
        }
        if (!$this->fecha_nacimiento) {
            $alertas['danger'][] = 'La fecha de nacimiento es obligatoria';
        }
        if (!$this->sexo) {
            $alertas['danger'][] = 'El sexo es obligatorio';
        }
        if (!$this->telefono) {
            $alertas['danger'][] = 'El teléfono es obligatorio';
        }
        if (!$this->email) {
            $alertas['danger'][] = 'El email es obligatorio';
        }
        if (!$this->direccion) {
            $alertas['danger'][] = 'La Dirección es obligatoria';
        }
        if (!$this->fecha_hora) {
            $alertas['danger'][] = 'La fecha y hora de la cita son obligatorias';
        }
        if (!$this->motivo) {
            $alertas['danger'][] = 'El motivo de la cita es obligatorio';
        }
        if (!$this->tipo_consulta) {
            $alertas['danger'][] = 'El tipo de consulta es obligatorio';
        }
        if (!$this->aceptar_terminos) {
            $alertas['danger'][] = 'Debe aceptar los términos y condiciones';
        }

        return $alertas;
    }
    
    
    

    // Obtener todas las citas
    public static function todas() {
        $query = "SELECT * FROM " . self::$tabla . " ORDER BY id DESC";
        return self::consultarSQL($query);
    }

    // Buscar citas por nombre del paciente
    public static function buscarPorNombrePaciente($nombre) {
        $query = "SELECT * FROM " . self::$tabla . "
                  WHERE nombre LIKE '%" . self::$db->escape_string($nombre) . "%'";
        return self::consultarSQL($query);
    }

     
    // Relación muchos a muchos con Paciente
    public function pacientes() {
        $query = "SELECT p.* FROM pacientes p 
                  JOIN paciente_cita_medica pcm ON p.id = pcm.paciente_id 
                  WHERE pcm.cita_medica_id = " . self::$db->escape_string($this->id);
        return self::consultarConJoin($query);
    }

    // Método para agregar un paciente a la cita médica
    public function agregarPaciente($paciente_id) {
        $query = "INSERT INTO paciente_cita_medica (paciente_id, cita_medica_id) 
                  VALUES (" . self::$db->escape_string($paciente_id) . ", " . self::$db->escape_string($this->id) . ")";
        return self::$db->query($query);
    }

    // Método para eliminar un paciente de la cita médica
    public function eliminarPaciente($paciente_id) {
        $query = "DELETE FROM paciente_cita_medica 
                  WHERE paciente_id = " . self::$db->escape_string($paciente_id) . " 
                  AND cita_medica_id = " . self::$db->escape_string($this->id);
        return self::$db->query($query);
    }

   // En lugar de usar getDB(), usa self::$db directamente
    public static function buscarPorEmail($email) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE email = '" . self::$db->escape_string($email) . "'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


}
?>
