<?php

namespace Model;

class Consulta extends ActiveRecord {

    protected static $tabla = 'consultas';
    protected static $columnasDB = [
        'id', 
        'paciente_id', 
        'motivo_consulta', 
        'tratamiento_sugerido', 
        'tiempo_tratamiento_clinico', 
        'diagnostico', 
        'observaciones', 
        'tiempo_tratamiento_sugerido', 
        'dosis_tratamiento'
    ];

    public $id;
    public $paciente_id;
    public $motivo_consulta;
    public $tratamiento_sugerido;
    public $tiempo_tratamiento_clinico;
    public $diagnostico;
    public $observaciones;
    public $tiempo_tratamiento_sugerido;
    public $dosis_tratamiento;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->paciente_id = $args['paciente_id'] ?? null;
        $this->motivo_consulta = $args['motivo_consulta'] ?? '';
        $this->tratamiento_sugerido = $args['tratamiento_sugerido'] ?? '';
        $this->tiempo_tratamiento_clinico = $args['tiempo_tratamiento_clinico'] ?? '';
        $this->tiempo_tratamiento_sugerido = $args['tiempo_tratamiento_sugerido'] ?? '';
        $this->diagnostico = $args['diagnostico'] ?? '';
        $this->observaciones = $args['observaciones'] ?? '';
        $this->tiempo_tratamiento_sugerido = $args['tiempo_tratamiento_sugerido'] ?? '';
        $this->dosis_tratamiento = $args['dosis_tratamiento'] ?? '';
    }

    // Mensajes de validación
    public function validarConsulta() {
        $alertas = [];

        if(!$this->motivo_consulta) {
            $alertas['error'][] = 'El motivo de consulta es obligatorio';
        }
        if(!$this->tratamiento_sugerido) {
            $alertas['error'][] = 'El tratamiento sugerido es obligatorio';
        }
        if(!$this->tiempo_tratamiento_clinico) {
            $alertas['error'][] = 'El tiempo de tratamiento clínico es obligatorio';
        }
        if(!$this->tiempo_tratamiento_sugerido) {
            $alertas['error'][] = 'El tiempo de tratamiento sugerido es obligatorio';
        }
        if(!$this->diagnostico) {
            $alertas['error'][] = 'El diagnóstico es obligatorio';
        }
        if(!$this->observaciones) {
            $alertas['error'][] = 'Las observaciones son obligatorias';
        }
        if(!$this->dosis_tratamiento) {
            $alertas['error'][] = 'La dosis del tratamiento es obligatoria';
        }

        return $alertas;
    }

    // Método para obtener consultas por pacientes
    public static function consultasPorPacientes(array $pacientes) {
        if (empty($pacientes)) {
            return [];
        }

        $idsPacientes = array_map(fn($paciente) => $paciente->id, $pacientes);
        $idsPacientes = implode(',', $idsPacientes);

        $query = "SELECT * FROM " . static::$tabla . " WHERE paciente_id IN ($idsPacientes)";
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // En los modelos
    public static function findByPacienteId($pacienteId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE paciente_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $pacienteId);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            return new static($datos);
        }
        
        return new static(); // Devuelve una nueva instancia
    }

    public static function findByConsultaId($consulta_id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ?";
        $stmt = self::$db->prepare($query);
        
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . self::$db->error);
        }
    
        $stmt->bind_param('i', $consulta_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            return new static($datos);
        }
    
        return new static(); // Devuelve una nueva instancia si no se encontraron datos
    }
    
    
}
