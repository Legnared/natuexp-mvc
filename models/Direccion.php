<?php

namespace Model;

class Direccion extends ActiveRecord {
    
    protected static $tabla = 'direcciones';
    protected static $columnasDB = [
        'id', 
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
    public $pais;
    public $calle;
    public $numero_exterior;
    public $numero_interior;
    public $colonia;
    public $municipio;
    public $estado;
    public $codigo_postal;

    private $error = [];

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
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

        if (!$this->pais) $alertas['error'][] = 'El país es obligatorio';
        if (!$this->calle) $alertas['error'][] = 'La calle es obligatoria';
        if (!$this->numero_exterior) $alertas['error'][] = 'El número exterior es obligatorio';
        if (!$this->colonia) $alertas['error'][] = 'La colonia es obligatoria';
        if (!$this->municipio) $alertas['error'][] = 'El municipio es obligatorio';
        if (!$this->estado) $alertas['error'][] = 'El estado es obligatorio';
        if (!$this->codigo_postal) $alertas['error'][] = 'El código postal es obligatorio';
    
        return $alertas;
    }

    public function guardar() {
        $validacion = $this->validar();
        if (!empty($validacion['error'])) {
            $this->error = $validacion['error'];
            return false;
        }
    
        try {
            if ($this->id) {
                return $this->actualizar();
            } else {
                return $this->crear();
            }
        } catch (\Exception $e) {
            $this->error[] = "Error en el método guardar: " . $e->getMessage();
            return false;
        }
    }

    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $this->sanitize($value);
            }
        }
    }

    public function delete() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }

    public static function findById($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ?";
        $stmt = self::$db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Error al preparar la consulta: " . self::$db->error);
        }

        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new \Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $resultado = $stmt->get_result();
        if (!$resultado) {
            throw new \Exception("Error al obtener el resultado: " . $stmt->error);
        }

        $dato = $resultado->fetch_assoc();
        $stmt->close();

        if ($dato) {
            return new static($dato);
        }

        return null;
    }

    public function crear() {
        $query = "INSERT INTO " . static::$tabla . " 
            (pais, calle, numero_exterior, numero_interior, colonia, municipio, estado, codigo_postal) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = self::$db->prepare($query);
        if (!$stmt) {
            $this->error[] = "Error en la preparación de la consulta: " . self::$db->error;
            return false;
        }

        $stmt->bind_param("ssssssss", $this->pais, $this->calle, $this->numero_exterior, $this->numero_interior, $this->colonia, $this->municipio, $this->estado, $this->codigo_postal);

        if ($stmt->execute()) {
            $this->id = self::$db->insert_id;
            $stmt->close();
            return true;
        } else {
            $this->error[] = "Error en la ejecución de la consulta: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }

    public function actualizar() {
        $query = "UPDATE " . static::$tabla . " 
                  SET pais = ?, calle = ?, numero_exterior = ?, numero_interior = ?, colonia = ?, municipio = ?, estado = ?, codigo_postal = ?
                  WHERE id = ?";

        $stmt = self::$db->prepare($query);
        if (!$stmt) {
            $this->error[] = "Error en la preparación de la consulta: " . self::$db->error;
            return false;
        }

        $stmt->bind_param("ssssssssi", $this->pais, $this->calle, $this->numero_exterior, $this->numero_interior, $this->colonia, $this->municipio, $this->estado, $this->codigo_postal, $this->id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $this->error[] = "Error en la ejecución de la consulta: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }

    public function debugValues() {
        echo "id: " . $this->id . "<br>";
        echo "pais: " . $this->pais . "<br>";
        echo "calle: " . $this->calle . "<br>";
        echo "numero_exterior: " . $this->numero_exterior . "<br>";
        echo "numero_interior: " . $this->numero_interior . "<br>";
        echo "colonia: " . $this->colonia . "<br>";
        echo "municipio: " . $this->municipio . "<br>";
        echo "estado: " . $this->estado . "<br>";
        echo "codigo_postal: " . $this->codigo_postal . "<br>";
    }

    // Relaciones
    public function pacientes() {
        return $this->hasMany(Pacient::class, 'direccion_id');
    }

    public function usuarios() {
        return $this->hasMany(Usuario::class, 'direccion_id');
    }
}
