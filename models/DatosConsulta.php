<?php

namespace Model;

class DatosConsulta extends ActiveRecord {

    protected static $tabla = 'datos_consulta';
    protected static $columnasDB = [
        'id',
        'paciente_id',
        'presion_arterial',
        'nivel_azucar',
        'peso',
        'estatura',
        'temperatura'
    ];

    public $id;
    public $paciente_id;
    public $presion_arterial;
    public $nivel_azucar;
    public $peso;
    public $estatura;
    public $temperatura;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->paciente_id = $args['paciente_id'] ?? null;
        $this->presion_arterial = $args['presion_arterial'] ?? '';
        $this->nivel_azucar = $args['nivel_azucar'] ?? '';
        $this->peso = $args['peso'] ?? '';
        $this->estatura = $args['estatura'] ?? '';
        $this->temperatura = $args['temperatura'] ?? '';
    }

    // Mensajes de validación
    public function validar() {
        $alertas = [];

        if (!$this->presion_arterial) {
            $alertas['error'][] = 'La presión arterial del Paciente es obligatoria';
        }
        if (!$this->nivel_azucar) {
            $alertas['error'][] = 'La Glucosa del Paciente es obligatorio';
        }
        if (empty($this->peso)) {
            $alertas['error'][] = 'El peso del Paciente es obligatorio';
        }
        if (empty($this->estatura)) {
            $alertas['error'][] = 'La estatura del Paciente es obligatoria';
        }
        if (empty($this->temperatura)) {
            $alertas['error'][] = 'La temperatura del Paciente es obligatoria';
        }
        

        return $alertas;
    }

    // Método para encontrar por paciente_id en DatosConsulta
    public static function findByPacienteId($pacienteId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE paciente_id = ?";
        $stmt = self::$db->prepare($query);

        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . self::$db->error);
        }

        $stmt->bind_param('i', $pacienteId);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado === false) {
            die('Error en la ejecución de la consulta: ' . $stmt->error);
        }

        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            return new static($datos);
        }

        return new static(); // Devuelve una nueva instancia si no se encontraron datos
    }



    // Método para encontrar por consulta_id
        // Método para encontrar por consulta_id
    public static function findByConsultaId($consulta_id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE consulta_id = ?";
        $stmt = self::$db->prepare($query);
        
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . self::$db->error);
        }

        $stmt->bind_param('i', $consulta_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado === false) {
            die('Error en la ejecución de la consulta: ' . self::$db->error);
        }
        
        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            return new static($datos);
        }
        
        return new static(); // Devuelve una nueva instancia si no se encontraron datos
    }

}