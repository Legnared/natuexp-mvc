<?php

namespace Model;

use DateTime;
use Exception;

class Pacient extends ActiveRecord
{
    protected static $tabla = 'pacientes';
    protected static $columnasDB = [
        'id', 'nombre', 'apellidos', 'fecha_nacimiento', 'edad', 'telefono', 'correo', 'sexo_id', 
        'usuario_id', 'expediente_file', 'foto', 'url_avance', 'estatus', 
        'fecha_creacion', 'fecha_modificacion', 'fecha_eliminacion'
    ];

    public $id;
    public $nombre;
    public $apellidos;
    public $fecha_nacimiento;
    public $edad;
    public $telefono;
    public $correo;
    public $sexo_id;
    public $usuario_id;
    public $expediente_file;
    public $foto;
    public $url_avance;
    public $estatus;
    public $fecha_creacion;
    public $fecha_modificacion;
    public $fecha_eliminacion;

    // Relación con la tabla consultas
    public function consultas()
    {
        return consultas::consultarSQL("SELECT * FROM consultas WHERE paciente_id = '{$this->id}'");
    }

    // Relación con la tabla direcciones
    public function direccion()
    {
        return Direccion::consultarSQL("SELECT * FROM direcciones WHERE paciente_id = '{$this->id}'");
    }

    // Relación con la tabla datos_consulta
    public function datosConsulta()
    {
        return DatosConsulta::consultarSQL("SELECT * FROM datos_consulta WHERE paciente_id = '{$this->id}'");
    }

    // Relación con la tabla antecedentes_medicos
    public function antecedentesMedicos()
    {
        return AntecedentesMedicos::consultarSQL("SELECT * FROM antecedentes_medicos WHERE paciente_id = '{$this->id}'");
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->fecha_nacimiento = $args['fecha_nacimiento'] ?? '';
        $this->edad = $args['edad'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->sexo_id = $args['sexo_id'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->expediente_file = $args['expediente_file'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->url_avance = $args['url_avance'] ?? '';
        $this->estatus = $args['estatus'] ?? '1'; // Default to active
        $this->fecha_creacion = $args['fecha_creacion'] ?? '';
        $this->fecha_modificacion = $args['fecha_modificacion'] ?? '';
        $this->fecha_eliminacion = $args['fecha_eliminacion'] ?? '';
    }

    public function calcularEdad() {
        if ($this->fecha_nacimiento) {
            $fecha_nacimiento = DateTime::createFromFormat('Y-m-d', $this->fecha_nacimiento);
            $hoy = new DateTime();
            return $hoy->diff($fecha_nacimiento)->y;
        }
        return null;
    }

    public function validar() {
        $alertas = [];

        if (!$this->nombre) {
            $alertas['error'][] = 'El Nombre(s) del Paciente es Obligatorio';
        }
        if (!$this->apellidos) {
            $alertas['error'][] = 'Los Apellido(s) del Paciente son Obligatorios';
        }

          // Validación básica con filter_var
        if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            $alertas['danger'][] = 'Email no válido';
        }

        // Expresión regular para validación adicional
        $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (!preg_match($emailPattern, $this->correo)) {
            $alertas['danger'][] = 'El Correo Electrónico no es válido';
        }

        if (!$this->fecha_nacimiento) {
            $alertas['error'][] = 'La Fecha de Nacimiento del Paciente es Obligatoria';
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

    // Método para obtener pacientes por usuario_id
    public static function pacientesPorUsuario($usuario_id) {
        $usuario_id_escapado = self::$db->escape_string($usuario_id);
        $query = "SELECT * FROM pacientes WHERE usuario_id = '{$usuario_id_escapado}' AND estatus = '1'";
        return self::consultarSQL($query);
    }

    public static function findByUrlAvance($url_avance) {
        $query = "SELECT * FROM pacientes WHERE url_avance = '$url_avance' AND estatus = '1'";
        return self::consultarSQL($query);
    }
}
