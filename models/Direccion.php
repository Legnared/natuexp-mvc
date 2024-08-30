<?php

namespace Model;

class Direccion extends ActiveRecord {
    
    protected static $tabla = 'direcciones';
    protected static $columnasDB = [
        'id', 
        'usuario_id',
        'pais',
        'calle', 
        'numero_exterior', 
        'numero_interior', 
        'colonia', 
        'municipio', 
        'estado', 
        'codigo_postal'
    ];

    public $id;
    public $usuario_id;
    public $pais;
    public $calle;
    public $numero_exterior;
    public $numero_interior;
    public $colonia;
    public $municipio;
    public $estado;
    public $codigo_postal;

    private $error = []; // Agrega esta propiedad para manejar errores

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->pais = $this->sanitize($args['pais'] ?? '');
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

    public function validar() {
        $alertas = [];

        if (!$this->pais) {
            $alertas['error'][] = 'El país es obligatorio';
        }
    
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

    public function guardar() {
        // Validar datos antes de guardar
        $validacion = $this->validar();
        if (!empty($validacion['error'])) {
            error_log("Errores de validación: " . print_r($validacion['error'], true));
            return false;
        }
        
        try {
            if ($this->id) {
                return $this->actualizar();
            } else {
                return $this->crear();
            }
        } catch (\Exception $e) {
            error_log("Error en el método guardar: " . $e->getMessage());
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
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }

    public function obtenerUsuario() {
        return Usuario::where('direccion_id', $this->id);
    }
    
    public function obtenerPaciente() {
        return Paciente::where('direccion_id', $this->id);
    }

    public static function findByPacienteId($pacienteId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE usuario_id = ?";
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

    public function getError() {
        return $this->error; // Ajusta según cómo manejes los errores en tus modelos
    }

    public function crear() {
        $validacion = $this->validar();
        if (!empty($validacion['error'])) {
            error_log("Errores de validación: " . print_r($validacion['error'], true));
            $this->error = $validacion['error'];
            return false;
        }
    
        $query = "INSERT INTO " . static::$tabla . " (usuario_id, pais, calle, numero_exterior, numero_interior, colonia, municipio, estado, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = self::$db->prepare($query);
    
        if (!$stmt) {
            error_log("Error en la preparación de la consulta: " . self::$db->error);
            return false;
        }
    
        $stmt->bind_param('issssssss', $this->usuario_id, $this->pais, $this->calle, $this->numero_exterior, $this->numero_interior, $this->colonia, $this->municipio, $this->estado, $this->codigo_postal);
    
        error_log("Datos a insertar: usuario_id={$this->usuario_id}, pais={$this->pais}, calle={$this->calle}, numero_exterior={$this->numero_exterior}, numero_interior={$this->numero_interior}, colonia={$this->colonia}, municipio={$this->municipio}, estado={$this->estado}, codigo_postal={$this->codigo_postal}");
    
        if ($stmt->execute()) {
            $this->id = self::$db->insert_id;
            return true;
        } else {
            error_log("Error en la consulta de inserción: " . $stmt->error);
            $this->error[] = "Error en la consulta de inserción: " . $stmt->error;
            return false;
        }
    }
    
    
    public function actualizar() {
        $query = "UPDATE " . static::$tabla . " SET pais = ?, calle = ?, numero_exterior = ?, numero_interior = ?, colonia = ?, municipio = ?, estado = ?, codigo_postal = ? WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ssssssssi', $this->pais, $this->calle, $this->numero_exterior, $this->numero_interior, $this->colonia, $this->municipio, $this->estado, $this->codigo_postal, $this->id);
        return $stmt->execute();
    }
}
