<?php

namespace Model;

class PacienteCitaMedica extends ActiveRecord {
    protected static $tabla = 'paciente_cita_medica';
    protected static $columnasDB = [
        'id', 'paciente_id', 'cita_medica_id'
    ];

    public $id;
    public $paciente_id;
    public $cita_medica_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->paciente_id = $args['paciente_id'] ?? null;
        $this->cita_medica_id = $args['cita_medica_id'] ?? null;
    }

   
}

