<?php

namespace Model;

class Direccion extends ActiveRecord {
    
    protected static $tabla = 'direcciones';
    protected static $columnasDB = [
        'id', 
        'paciente_id', 
        'calle', 
        'numero_exterior', 
        'numero_interior', 
        'colonia', 
        'municipio', 
        'estado', 
        'codigo_postal'
    ];

    public $id;
    public $paciente_id;
    public $calle;
    public $numero_exterior;
    public $numero_interior;
    public $colonia;
    public $municipio;
    public $estado;
    public $codigo_postal;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->paciente_id = $args['paciente_id'] ?? null;
        $this->calle = $this->sanitize($args['calle'] ?? '');
        $this->numero_exterior = $this->sanitize($args['numero_exterior'] ?? '');
        $this->numero_interior = $this->sanitize($args['numero_interior'] ?? '');
        $this->colonia = $this->sanitize($args['colonia'] ?? '');
        $this->municipio = $this->sanitize($args['municipio'] ?? '');
        $this->estado = $this->sanitize($args['estado'] ?? '');
        $this->codigo_postal = $this->sanitize($args['codigo_postal'] ?? '');
    }
    
    private function sanitize($data) {
        return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
    }

    public function validarDireccion() {
        $alertas = [];
    
        if (!$this->calle) {
            $alertas['error'][] = 'La calle es obligatoria';
        }
    
        if (!$this->numero_exterior) {
            $alertas['error'][] = 'El número exterior es obligatorio';
        }
    
        if (!$this->numero_interior) {
            $alertas['error'][] = 'El número interior es obligatorio';
        }
    
        if (!$this->colonia) {
            $alertas['error'][] = 'La colonia es obligatoria';
        }
    
        if (!$this->municipio) {
            $alertas['error'][] = 'El municipio es obligatorio';
        }
    
        if (!$this->estado) {
            $alertas['error'][] = 'El estado es obligatorio';
        }
    
        if (!$this->codigo_postal) {
            $alertas['error'][] = 'El código postal es obligatorio';
        }
    
        return $alertas;
    }
    
    public function save() {
        try {
            if (!is_null($this->id)) {
                return $this->actualizar();
            } else {
                return $this->crear();
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
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

    public function delete() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . $this->id;
        return self::ejecutarSQL($query);
    }

    // Relación inversa: obtener el usuario asociado a la dirección
    public function obtenerUsuario() {
        return Usuario::where('direccion_id', $this->id);
    }
    
    // Relación inversa: obtener el paciente asociado a la dirección
    public function obtenerPaciente() {
        return Paciente::where('direccion_id', $this->id);
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