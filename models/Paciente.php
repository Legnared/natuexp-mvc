<?php

namespace Model;

use DateTime;
use Exception;

class Paciente extends ActiveRecord
{
    protected static $tabla = 'pacientes';
    protected static $columnasDB = [
        'id', 'nombre', 'apellidos', 'fecha_nacimiento', 'edad', 'telefono', 'correo',
        'motivo_consulta', 'tratamiento_sujerido', 'tiempo_tratamiento_clinico', 'diagnostico',
        'observaciones', 'tiempo_tratamiento_sujerido', 'dosis_tratamiento', 'expediente_file',
        'foto', 'sexo_id', 'usuario_id', 'url_avance', 'estatus', 'fecha_creacion',
        'fecha_modificacion', 'fecha_eliminacion', 'calle', 'numero_exterior', 'numero_interior',
        'colonia', 'municipio', 'estado', 'codigo_postal', 'presion_arterial', 'nivel_azucar',
        'peso', 'estatura', 'temperatura', 'diabetes', 'cancer', 'obesidad', 'infartos',
        'alergias', 'depresion', 'artritis', 'estrenimiento', 'gastritis', 'comida_chatarra',
        'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos', 'num_cirugias', 'desc_cirugias',
        'num_embarazos', 'num_abortos'
    ];

    public $id;
    public $nombre;
    public $apellidos;
    public $fecha_nacimiento;
    public $edad;
    public $telefono;
    public $correo;
    public $motivo_consulta;
    public $tratamiento_sujerido;
    public $tiempo_tratamiento_clinico;
    public $diagnostico;
    public $observaciones;
    public $tiempo_tratamiento_sujerido;
    public $dosis_tratamiento;
    public $expediente_file;
    public $foto;
    public $sexo_id;
    public $usuario_id;
    public $url_avance;
    public $estatus;
    public $fecha_creacion;
    public $fecha_modificacion;
    public $fecha_eliminacion;

    public $calle;
    public $numero_exterior;
    public $numero_interior;
    public $colonia;
    public $municipio;
    public $estado;
    public $codigo_postal;

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

    public function __construct($args = [])
    {
        
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->fecha_nacimiento = $args['fecha_nacimiento'] ?? '';
        $this->edad = $args['edad'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->motivo_consulta = $args['motivo_consulta'] ?? '';
        $this->tratamiento_sujerido = $args['tratamiento_sujerido'] ?? '';
        $this->tiempo_tratamiento_clinico = $args['tiempo_tratamiento_clinico'] ?? '';
        $this->diagnostico = $args['diagnostico'] ?? '';
        $this->observaciones = $args['observaciones'] ?? '';
        $this->tiempo_tratamiento_sujerido = $args['tiempo_tratamiento_sujerido'] ?? '';
        $this->dosis_tratamiento = $args['dosis_tratamiento'] ?? '';
        $this->expediente_file = $args['expediente_file'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->sexo_id = $args['sexo_id'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->url_avance = $args['url_avance'] ?? '';
        $this->estatus = $args['estatus'] ?? '1'; // Default to active
        $this->fecha_creacion = $args['fecha_creacion'] ?? '';
        $this->fecha_modificacion = $args['fecha_modificacion'] ?? '';
        $this->fecha_eliminacion = $args['fecha_eliminacion'] ?? '';

        $this->calle = $args['calle'] ?? '';
        $this->numero_exterior = $args['numero_exterior'] ?? '';
        $this->numero_interior = $args['numero_interior'] ?? '';
        $this->colonia = $args['colonia'] ?? '';
        $this->municipio = $args['municipio'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->codigo_postal = $args['codigo_postal'] ?? '';

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
        if (!$this->motivo_consulta) {
            $alertas['error'][] = 'El Motivo de Consulta del Paciente es Obligatorio';
        }
        if (!$this->tratamiento_sujerido) {
            $alertas['error'][] = 'El Tratamiento Sugerido del Paciente es Obligatorio';
        }
        if (!$this->tiempo_tratamiento_clinico) {
            $alertas['error'][] = 'El Tiempo de Tratamiento Clínico es Obligatorio';
        }
        if (!$this->tiempo_tratamiento_sujerido) {
            $alertas['error'][] = 'El Tiempo de Tratamiento Sugerido es Obligatorio';
        }
        if (!$this->diagnostico) {
            $alertas['error'][] = 'El Diagnóstico Clínico es Obligatorio';
        }
        if (!$this->dosis_tratamiento) {
            $alertas['error'][] = 'La Dosis del Tratamiento es Obligatoria';
        }
        if ($this->peso <= 0) {
            $alertas['error'][] = 'El Peso debe ser un valor positivo';
        }
        if ($this->estatura <= 0) {
            $alertas['error'][] = 'La Estatura debe ser un valor positivo';
        }
        if ($this->temperatura <= 0) {
            $alertas['error'][] = 'La Temperatura debe ser un valor positivo';
        }
        if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            $alertas['error'][] = 'El Correo Electrónico no es válido';
        }

        return $alertas;
    }

    public function save() {
        $resultado = '';
        if (!is_null($this->id)) {
            $resultado = $this->actualizar();
        } else {
            $resultado = $this->crear();
        }
        return $resultado;
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
        // Escapar el ID del usuario para evitar inyección SQL
        $usuario_id_escapado = self::$db->escape_string($usuario_id);
        
        // Consulta SQL para obtener pacientes activos por usuario_id
        $query = "SELECT * FROM pacientes WHERE usuario_id = '{$usuario_id_escapado}' AND estatus = '1'";
        
        // Ejecutar la consulta y devolver el resultado
        return self::consultarSQL($query);
    }
    

    public function obtenerPacientesActivos() {
        $query = "SELECT * FROM pacientes WHERE estatus = '1'"; // Asegúrate de que '1' indica activo
        $resultado = self::$db->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC); // Ajusta según cómo manejas los resultados
    }

    public static function findByUrlAvance($url_avance) {
        $query = "SELECT * FROM pacientes WHERE url_avance = '$url_avance' AND estatus = '1'";
        return self::consultarSQL($query);
    }
    
    

    
}