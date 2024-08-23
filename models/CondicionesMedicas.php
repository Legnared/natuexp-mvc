<?php

namespace Model;

class CondicionesMedicas extends ActiveRecord {
    protected static $tabla = 'condiciones_medicas';
    protected static $columnasDB = [
        'id', 'paciente_id', 'presion_arterial', 'nivel_azucar', 'peso', 'estatura', 'temperatura',
        'diabetes', 'cancer', 'obesidad', 'infartos', 'alergias', 'depresion', 'artritis', 'estrenimiento',
        'gastritis', 'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos',
        'num_cirugias', 'desc_cirugias', 'num_embarazos', 'num_abortos'
    ];

    public $id;
    public $paciente_id;
    public $presion_arterial;
    public $nivel_azucar;
    public $peso;
    public $estatura;
    public $temperatura;
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

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->paciente_id = $args['paciente_id'] ?? null;
        $this->presion_arterial = $args['presion_arterial'] ?? '';
        $this->nivel_azucar = $args['nivel_azucar'] ?? '';
        $this->peso = $args['peso'] ?? null;
        $this->estatura = $args['estatura'] ?? null;
        $this->temperatura = $args['temperatura'] ?? null;
        $this->diabetes = $args['diabetes'] ?? '0';
        $this->cancer = $args['cancer'] ?? '0';
        $this->obesidad = $args['obesidad'] ?? '0';
        $this->infartos = $args['infartos'] ?? '0';
        $this->alergias = $args['alergias'] ?? '0';
        $this->depresion = $args['depresion'] ?? '0';
        $this->artritis = $args['artritis'] ?? '0';
        $this->estrenimiento = $args['estrenimiento'] ?? '0';
        $this->gastritis = $args['gastritis'] ?? '0';
        $this->comida_chatarra = $args['comida_chatarra'] ?? '0';
        $this->fumas = $args['fumas'] ?? '0';
        $this->bebes = $args['bebes'] ?? '0';
        $this->cirugias = $args['cirugias'] ?? '0';
        $this->embarazos = $args['embarazos'] ?? '0';
        $this->abortos = $args['abortos'] ?? '0';
        $this->num_cirugias = $args['num_cirugias'] ?? null;
        $this->desc_cirugias = htmlspecialchars($args['desc_cirugias'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->num_embarazos = $args['num_embarazos'] ?? null;
        $this->num_abortos = $args['num_abortos'] ?? null;
    }

    public function validarCondicionesMedicas() {
        $alertas = [];

        // Validaciones para campos textuales
        if (!$this->presion_arterial) {
            $alertas['error'][] = 'La presión arterial es un campo obligatorio y no puede estar vacío.';
        }

        if(!$this->nivel_azucar) {
            $alertas['error'][] = 'El Nivel de Azucar es Obligatorio';
        }
        if(!$this->peso) {
            $alertas['error'][] = 'El Peso del Paciente es Obligatorio';
        }
        if(!$this->estatura) {
            $alertas['error'][] = 'El Estatura del Paciente es Obligatorio';
        }
        if (!is_null($this->temperatura) && !is_numeric($this->temperatura)) {
            $alertas['error'][] = 'La temperatura es obligatoria y debe ser (numérica & decimal).';
        }
        

        return $alertas;
    }

    public function save() {
        if (!is_null($this->id)) {
            return $this->actualizar();
        } else {
            return $this->crear();
        }
    }

    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // public static function findByPacienteId($pacienteId) {
    //     $pacienteIdEscapado = self::$db->escape_string($pacienteId);
    //     $query = "SELECT * FROM condiciones_medicas WHERE id_paciente = '{$pacienteIdEscapado}'";
    //     $resultado = self::consultarSQL($query);
    //     return array_shift($resultado);
    // }

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

?>