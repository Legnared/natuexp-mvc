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
        $this->peso = $args['peso'] ?? null;
        $this->estatura = $args['estatura'] ?? null;
        $this->temperatura = $args['temperatura'] ?? null;
    }

    // Mensajes de validación
    public function validar() {
        $alertas = [];

        if (!$this->presion_arterial) {
            $alertas['error'][] = 'La presión arterial es obligatoria';
        }
        if (!$this->nivel_azucar) {
            $alertas['error'][] = 'El nivel de azúcar es obligatorio';
        }
        if ($this->peso === null) {
            $alertas['error'][] = 'El peso es obligatorio';
        }
        if ($this->estatura === null) {
            $alertas['error'][] = 'La estatura es obligatoria';
        }
        if ($this->temperatura === null) {
            $alertas['error'][] = 'La temperatura es obligatoria';
        }

        return $alertas;
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
}
