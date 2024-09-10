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
        'fecha_creacion', 'fecha_modificacion', 'fecha_eliminacion', 'direccion_id'
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
    public $direccion_id;

    // Relación con la tabla consultas
    public function consultas()
    {
        return Consulta::consultarSQL("SELECT * FROM consultas WHERE paciente_id = '{$this->id}'");
    }

    // Relación con la tabla direcciones
    public function direcciones() {
        return Direccion::findByPacienteId($this->id);
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
        if (!$this->telefono) {
            $alertas['error'][] = 'El Teléfono del Paciente son Obligatorio';
        }

          // Validación básica con filter_var
        if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            $alertas['error'][] = 'Email no válido';
        }

        // Expresión regular para validación adicional
        $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (!preg_match($emailPattern, $this->correo)) {
            $alertas['error'][] = 'El Correo Electrónico no es válido';
        }

        if (!$this->fecha_nacimiento) {
            $alertas['error'][] = 'La Fecha de Nacimiento del Paciente es Obligatoria';
        }
        if (!$this->edad) {
            $alertas['error'][] = 'La Edad se calcula con la Fecha Nacimiento y es Obligatoria';
        }

        $this->validarExpedienteFile();

        return $alertas;
    }

    public function save() {
        self::$db->begin_transaction();
        
        try {
            if (!is_null($this->id)) {
                $this->actualizar();
            } else {
                $this->crear();
            }
    
            // Guardar direcciones asociadas
            foreach ($this->direcciones() as $direccion) {
                $direccion->paciente_id = $this->id;
                $direccion->guardar();
            }
    
            self::$db->commit();
            return true;
    
        } catch (Exception $e) {
            self::$db->rollback();
            self::$alertas['error'][] = "Error al guardar: " . $e->getMessage();
            return false;
        }
    }
    

    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        $query = "SELECT * FROM pacientes WHERE estatus != 0";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    
    public static function countByRoles($roles) {
        $roles_string = implode(',', array_map('intval', $roles));
        $query = "SELECT COUNT(*) FROM pacientes WHERE rol_id IN ($roles_string)";
        $resultado = self::$db->query($query);
        return $resultado->fetchColumn();
    }
    

    // Método para obtener pacientes por usuario_id
    public static function pacientesPorUsuario($usuario_id) {
        $usuario_id_escapado = self::$db->escape_string($usuario_id);
        $query = "SELECT * FROM pacientes WHERE usuario_id = '{$usuario_id_escapado}' AND estatus = '1'";
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

    public function validarExpedienteFile() {
        if (isset($_FILES['expediente_file']) && !empty($_FILES['expediente_file']['name'][0])) {
            foreach ($_FILES['expediente_file']['tmp_name'] as $key => $tmp_name) {
                $fileName = $_FILES['expediente_file']['name'][$key];
                $fileSize = $_FILES['expediente_file']['size'][$key];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Validar el tamaño del archivo (10MB máximo)
                if ($fileSize > 10000000) {
                    self::$alertas['danger'][] = "El archivo {$fileName} es demasiado grande. El tamaño máximo permitido es de 10MB.";
                }
                
                // Validar la extensión del archivo
                $allowedExtensions = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'webp'];
                if (!in_array($fileExtension, $allowedExtensions)) {
                    self::$alertas['error'][] = "El tipo de archivo para {$fileName} no está permitido. Los formatos permitidos son: PDF, DOC, DOCX, PNG, JPG, JPEG, WEBP.";
                }
            }
        } else {
            self::$alertas['error'][] = "El campo Expediente Médico es obligatorio.";
        }
    }
    
    public function validarFoto()
    {
        $alertas = [];

        // Validar si el archivo de foto está presente y es válido
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            $alertas['error'][] = 'Error al subir la foto del paciente.';
        } else {
            // Validar tipo y tamaño del archivo
            $tipoArchivo = $_FILES['foto']['type'];
            $tamanoArchivo = $_FILES['foto']['size'];

            if (!in_array($tipoArchivo, ['image/jpeg', 'image/png', 'image/webp'])) {
                $alertas['error'][] = 'El archivo debe ser una imagen JPEG, PNG o WEBP.';
            }

            if ($tamanoArchivo > 5000000) { // 5 MB como ejemplo
                $alertas['error'][] = 'El archivo debe ser menor de 5 MB.';
            }
        }

        return $alertas;
    }
    
     // Relación con Direccion
     public function direccion() {
        return $this->belongsTO(Direccion::class, 'direccion_id');
    }

    
}
