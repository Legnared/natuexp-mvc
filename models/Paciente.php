<?php


namespace Model;

class Paciente extends ActiveRecord {
    protected static $tabla = 'pacientes';
    protected static $columnasDB = [
        'id', 'nombre', 'apellidos', 'edad', 'telefono', 'correo', 'motivo_consulta', 
        'tratamiento_sujerido', 'tiempo_tratamiento_clinico', 'tiempo_tratamiento_sujerido', 
        'diagnostico', 'observaciones', 'dosis_tratamiento', 'expediente_file', 
        'sexo_id', 'usuario_id', 'url_avance', 'estatus', 'fecha_creacion', 
        'fecha_modificacion', 'fecha_eliminacion', 'fecha_nacimiento', 
        'n_calle_avenida', 'n_exterior', 'n_interior', 'colonia_barrio', 
        'municipio_delegacion', 'estado_provincia', 'cp',
        'presion_arterial', 'nivel_azucar', 'peso', 'estatura', 'temperatura',
        'diabetes', 'cancer', 'obesidad', 'infartos', 'alergias', 
        'depresion', 'artritis', 'estrenimiento', 'gastritis', 
        'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos',
        'num_cirugias', 'desc_cirugias', 'num_embarazos', 'num_abortos'
    ];

    public $id;
    public $nombre;
    public $apellidos;
    public $edad;
    public $correo;
    public $telefono;
    public $motivo_consulta;
    public $tratamiento_sujerido;
    public $tiempo_tratamiento_clinico;
    public $tiempo_tratamiento_sujerido;
    public $dosis_tratamiento;
    public $expediente_file;
    public $sexo_id;
    public $usuario_id;
    public $url_avance;
    public $estatus;
    public $fecha_creacion;
    public $fecha_modificacion;
    public $fecha_eliminacion;
    public $fecha_nacimiento;
    public $n_calle_avenida;
    public $n_exterior;
    public $n_interior;
    public $colonia_barrio;
    public $municipio_delegacion;
    public $estado_provincia;
    public $cp;
    public $presion_arterial;
    public $nivel_azucar;
    public $peso;
    public $temperatura;
    public $estatura;

    public $diagnostico;
    public $observaciones;

    // Añadir nuevos campos de antecedentes
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

      // Nuevos campos para detalles adicionales
      public $num_cirugias;
      public $desc_cirugias;
      public $num_embarazos;
      public $num_abortos;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = htmlspecialchars($args['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->apellidos = htmlspecialchars($args['apellidos'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->edad = $args['edad'] ?? '';
        $this->telefono = $args['telefono'] ?? null;
        $this->correo = htmlspecialchars($args['correo'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->motivo_consulta = htmlspecialchars($args['motivo_consulta'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->tratamiento_sujerido = htmlspecialchars($args['tratamiento_sujerido'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->tiempo_tratamiento_clinico = $args['tiempo_tratamiento_clinico'] ?? '';
        $this->tiempo_tratamiento_sujerido = $args['tiempo_tratamiento_sujerido'] ?? '';
        $this->diagnostico = htmlspecialchars($args['diagnostico'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->observaciones = htmlspecialchars($args['observaciones'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->dosis_tratamiento = htmlspecialchars($args['dosis_tratamiento'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->expediente_file = $args['expediente_file'] ?? '';
        $this->sexo_id = $args['sexo_id'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->url_avance = $args['url_avance'] ?? '';
        $this->estatus = $args['estatus'] ?? 1;
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->fecha_modificacion = $args['fecha_modificacion'] ?? null;
        $this->fecha_eliminacion = $args['fecha_eliminacion'] ?? null;
        $this->fecha_nacimiento = $args['fecha_nacimiento'] ?? null;
        $this->n_calle_avenida = htmlspecialchars($args['n_calle_avenida'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->n_exterior = htmlspecialchars($args['n_exterior'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->n_interior = htmlspecialchars($args['n_interior'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->colonia_barrio = htmlspecialchars($args['colonia_barrio'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->municipio_delegacion = htmlspecialchars($args['municipio_delegacion'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->estado_provincia = htmlspecialchars($args['estado_provincia'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->cp = $args['cp'] ?? '';
        $this->presion_arterial = htmlspecialchars($args['presion_arterial'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->nivel_azucar = htmlspecialchars($args['nivel_azucar'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->peso = $args['peso'] ?? '';
        $this->estatura = $args['estatura'] ?? '';
        $this->temperatura = $args['temperatura'] ?? '';

        // Inicializar nuevos campos de antecedentes
        $this->diabetes = $args['diabetes'] ?? '';
        $this->cancer = $args['cancer'] ?? '';
        $this->obesidad = $args['obesidad'] ?? '';
        $this->infartos = $args['infartos'] ?? '';
        $this->alergias = $args['alergias'] ?? '';
        $this->depresion = $args['depresion'] ?? '';
        $this->artritis = $args['artritis'] ?? '';
        $this->estrenimiento = $args['estrenimiento'] ?? '';
        $this->gastritis = $args['gastritis'] ?? '';
        $this->comida_chatarra = $args['comida_chatarra'] ?? '';
        $this->fumas = $args['fumas'] ?? '';
        $this->bebes = $args['bebes'] ?? '';
        $this->cirugias = $args['cirugias'] ?? '';
        $this->embarazos = $args['embarazos'] ?? '';
        $this->abortos = $args['abortos'] ?? '';

           // Inicializar campos adicionales
        $this->num_cirugias = $args['num_cirugias'] ?? '';
        $this->desc_cirugias = htmlspecialchars($args['desc_cirugias'] ?? '', ENT_QUOTES, 'UTF-8');
        $this->num_embarazos = $args['num_embarazos'] ?? '';
        $this->num_abortos = $args['num_abortos'] ?? '';
    
    }

    // Método para calcular la edad
    public function calcularEdad() {
        if($this->fecha_nacimiento) {
            $fecha_nacimiento = new \DateTime($this->fecha_nacimiento);
            $hoy = new \DateTime();
            $edad = $hoy->diff($fecha_nacimiento)->y;
            return $edad;
        }
        return null;
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre(s) del Paciente es Obligatorio';
        }
        if(!$this->apellidos) {
            self::$alertas['error'][] = 'Los Apellidos del Paciente son Obligatorios';
        }
        if(!$this->fecha_nacimiento) {
            self::$alertas['error'][] = 'La Fecha de Nacimiento del Paciente es Obligatoria';
        }
        if(!$this->motivo_consulta) {
            self::$alertas['error'][] = 'El Motivo de Consulta del Paciente es Obligatorio';
        }
        if(!$this->tratamiento_sujerido) {
            self::$alertas['error'][] = 'El Tratamiento Sugerido del Paciente es Obligatorio';
        }
        if(!$this->tiempo_tratamiento_clinico) {
            self::$alertas['error'][] = 'El Tiempo de Tratamiento Clínico es Obligatorio';
        }
        if(!$this->tiempo_tratamiento_sujerido) {
            self::$alertas['error'][] = 'El Tiempo de Tratamiento Sugerido es Obligatorio';
        }
        if(!$this->diagnostico) {
            self::$alertas['error'][] = 'El Diágnostico Clínico es Obligatorio';
        }
       
        if(!$this->dosis_tratamiento) {
            self::$alertas['error'][] = 'La Dosis de Tratamiento es Obligatoria';
        }
        if(!$this->expediente_file) {
            self::$alertas['error'][] = 'El Expediente Médico es Obligatorio';
        }
        if(!$this->sexo_id || !filter_var($this->sexo_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Selecciona el Sexo del Paciente';
        }

        return self::$alertas;
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

    // En el modelo Paciente.php
    public static function findByUrlAvance($url_avance)
    {
        // Asumiendo que $db es tu conexión a la base de datos
        $query = "SELECT * FROM pacientes WHERE url_avance = :url_avance LIMIT 1";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':url_avance', $url_avance);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}