<?php
namespace Model;

class Cita extends ActiveRecord {
    
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'paciente_id', 'fecha', 'hora', 'nombre_paciente', 'apellidos_paciente', 'descripcion'];

    public $id;
    public $paciente_id;
    public $fecha;
    public $hora;
    public $nombre_paciente;
    public $apellidos_paciente;
    public $descripcion;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->paciente_id = $args['paciente_id'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->nombre_paciente = $args['nombre_paciente'] ?? '';
        $this->apellidos_paciente = $args['apellidos_paciente'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
    }

    public function validar() {
        $alertas = [];

        if (!$this->fecha) {
            $alertas['error'][] = 'La fecha es obligatoria';
        }
        if (!$this->hora) {
            $alertas['error'][] = 'La hora es obligatoria';
        }
        if (!$this->descripcion) {
            $alertas['error'][] = 'La descripción es obligatoria';
        }

        return $alertas;
    }

    

    // Obtener todas las citas con datos del paciente usando JOIN, filtradas por usuario_id
    public static function todos($usuario_id) {
        $query = "SELECT c.*, p.nombre AS nombre_paciente, p.apellidos AS apellidos_paciente 
                  FROM citas c
                  JOIN pacientes p ON c.paciente_id = p.id
                  WHERE p.usuario_id = " . self::$db->escape_string($usuario_id) . "
                  ORDER BY c.id DESC";

        return self::consultarConJoinDinamico($query, __CLASS__);
    }

    public static function buscarPorNombrePaciente($nombre) {
        $query = "SELECT c.*, p.nombre AS nombre_paciente, p.apellidos AS apellidos_paciente 
                  FROM citas c
                  JOIN pacientes p ON c.paciente_id = p.id
                  WHERE p.nombre LIKE '%" . self::$db->escape_string($nombre) . "%'
                  OR p.apellidos LIKE '%" . self::$db->escape_string($nombre) . "%'";

        $result = self::consultarSQL($query);

        error_log("Consulta SQL ejecutada: " . $query);
        error_log("Resultados de la consulta: " . print_r($result, true));

        return $result;
    }

    public static function pacientesPorUsuario($usuario_id) {
        $query = "SELECT * FROM pacientes WHERE usuario_id = " . self::$db->escape_string($usuario_id);
        return self::consultarSQL($query);
    }
}

?>
