<?php

namespace Model;

class AntecedentesMedicos extends ActiveRecord {

    protected static $tabla = 'antecedentes_medicos';
    protected static $columnasDB = [
        'id',
        'paciente_id',
        'diabetes',
        'cancer',
        'obesidad',
        'infartos',
        'alergias',
        'depresion',
        'artritis',
        'estrenimiento',
        'gastritis',
        'comida_chatarra',
        'fumas',
        'bebes',
        'cirugias',
        'embarazos',
        'abortos',
        'num_cirugias',
        'desc_cirugias',
        'num_embarazos',
        'num_abortos'
    ];

    public $id;
    public $paciente_id;
    public $diabetes;
    public $cancer;
    public $obesidad;
    public $infartos;
    public $alergias;
    public $depresion;
    public $artritis;
    public $estrenimiento;
    public $gastritis;
    public $comida_chatarra;
    public $fumas;
    public $bebes;
    public $cirugias;
    public $embarazos;
    public $abortos;
    public $num_cirugias;
    public $desc_cirugias;
    public $num_embarazos;
    public $num_abortos;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->paciente_id = $args['paciente_id'] ?? null;
        $this->diabetes = $args['diabetes'] ?? 0;
        $this->cancer = $args['cancer'] ?? 0;
        $this->obesidad = $args['obesidad'] ?? 0;
        $this->infartos = $args['infartos'] ?? 0;
        $this->alergias = $args['alergias'] ?? 0;
        $this->depresion = $args['depresion'] ?? 0;
        $this->artritis = $args['artritis'] ?? 0;
        $this->estrenimiento = $args['estrenimiento'] ?? 0;
        $this->gastritis = $args['gastritis'] ?? 0;
        $this->comida_chatarra = $args['comida_chatarra'] ?? 0;
        $this->fumas = $args['fumas'] ?? 0;
        $this->bebes = $args['bebes'] ?? 0;
        $this->cirugias = $args['cirugias'] ?? 0;
        $this->embarazos = $args['embarazos'] ?? 0;
        $this->abortos = $args['abortos'] ?? 0;
        $this->num_cirugias = $args['num_cirugias'] ?? null;
        $this->desc_cirugias = $args['desc_cirugias'] ?? '';
        $this->num_embarazos = $args['num_embarazos'] ?? null;
        $this->num_abortos = $args['num_abortos'] ?? null;
    }

    // Mensajes de validación
    public function validar() {
        $alertas = [];

        if ($this->cirugias && is_null($this->num_cirugias)) {
            $alertas['error'][] = 'El número de cirugías es obligatorio si se ha indicado que tiene cirugías';
        }
        if ($this->cirugias && empty($this->desc_cirugias)) {
            $alertas['error'][] = 'La descripción de las cirugías es obligatoria si se ha indicado que tiene cirugías';
        }
        if ($this->embarazos && is_null($this->num_embarazos)) {
            $alertas['error'][] = 'El número de embarazos es obligatorio si se ha indicado que tiene embarazos';
        }
        if ($this->abortos && is_null($this->num_abortos)) {
            $alertas['error'][] = 'El número de abortos es obligatorio si se ha indicado que tiene abortos';
        }

        return $alertas;
    }

    public static function findByPacienteId($pacienteId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE paciente_id = ?";
    
        $stmt = self::$db->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . self::$db->error);
        }
    
        $stmt->bind_param('i', $pacienteId);
        $stmt->execute();
    
        $resultado = $stmt->get_result();
        if ($resultado === false) {
            throw new Exception("Error al obtener el resultado: " . $stmt->error);
        }
    
        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            return new static($datos);
        }
    
        return new static();
    }
    
    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
