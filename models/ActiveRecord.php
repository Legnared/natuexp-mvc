<?php

namespace Model;

class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    //
    public static function getDB() { 
        return self::$db;
    }
    

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas()
    {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    // public function sanitizarAtributos() {
    //     $atributos = $this->atributos();
    //     $sanitizado = [];
    //     foreach ($atributos as $key => $value) {
    //         $sanitizado[$key] = self::$db->escape_string($value);
    //     }
    //     return $sanitizado;
    // }
    public function sanitizarAtributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if(!is_null($this->$columna)) {
                $atributos[$columna] = self::$db->escape_string($this->$columna);
            }
        }
        return $atributos;
    }
    

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Método para crear un nuevo registro
    // public function crear() {
    //     // Sanitizar los datos
    //     $atributos = $this->sanitizarAtributos();

    //     // Insertar en la base de datos
    //     $query = "INSERT INTO " . static::$tabla . " (" . join(', ', array_keys($atributos)) . ") VALUES ('" . join("', '", array_values($atributos)) . "')";

    //     $resultado = self::$db->query($query);

    //     return $resultado;
    // }
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Construir la consulta SQL
        $campos = join(', ', array_keys($atributos));
        $valores = join(', ', array_fill(0, count($atributos), '?'));
        
        $query = "INSERT INTO " . static::$tabla . " ($campos) VALUES ($valores)";
        
        // Preparar la consulta
        $stmt = self::$db->prepare($query);
    
        // Crear un array de valores para bind_param
        $tipos = str_repeat('s', count($atributos)); // Asumiendo que todos los atributos son strings. Ajustar según el tipo de datos.
        $params = array_values($atributos);
        
        // Vincular parámetros
        $stmt->bind_param($tipos, ...$params);
        
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Verificar si la consulta fue exitosa
        if ($resultado) {
            $this->id = self::$db->insert_id; // Asignar el ID del registro insertado
        }
        
        return $resultado;
    }
    
    

    // Método para actualizar un registro existente
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Preparar la consulta
        $valores = [];
        $tipos = '';
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}=?";
            $tipos .= 's'; // Asumiendo que todos los atributos son strings. Ajustar según el tipo de datos.
        }
        $query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores) . " WHERE id=? LIMIT 1";
    
        // Preparar la consulta
        $stmt = self::$db->prepare($query);
    
        // Agregar el ID al final de los parámetros
        $params = array_values($atributos);
        $params[] = $this->id;
        $tipos .= 'i'; // ID es un entero
    
        // Vincular parámetros
        $stmt->bind_param($tipos, ...$params);
        
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        return $resultado;
    }
    

    // Obtener todos los Registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener todos los Registros en orden Descendente
    public static function allDesc($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id ${orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Paginar los registros
    public static function paginar($por_pagina, $offset) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT ${por_pagina} OFFSET ${offset} ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    //     El método where realiza los siguientes pasos:

    // 1. Construye una consulta SQL segura con un marcador de posición para el valor.
    // 2. Prepara la consulta y vincula el valor a través de un parámetro.
    // 3. Ejecuta la consulta y obtiene el resultado.
    // 4. Convierte el resultado en un objeto usando un método específico (crearObjeto).
    // Este enfoque proporciona seguridad mediante consultas preparadas y es flexible para 
    // buscar registros basados en cualquier columna y valor.
    public static function whereFlexible($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $valor);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return static::crearObjeto($resultado->fetch_assoc());
    }
    


    // Nueva función whereAll que devuelve todos los resultados
    public static function whereAll($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado; // Devolver todos los resultados como un array asociativo
    }

    // Método estático para buscar registros que pertenecen a un ID específico
    public static function belongsTo($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Retornar los registros por un orden
    public static function ordenar($columna, $orden) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY ${columna} ${orden} ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Retornar por orden y con un limite
    public static function ordenarLimite($columna, $orden, $limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY ${columna} ${orden} LIMIT ${limite} ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Múltiples opciones
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach ($array as $key => $value) {
            if ($key == array_key_last($array)) {
                $query .= " ${key} = '${value}'";
            } else {
                $query .= " ${key} = '${value}' AND ";
            }
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Traer un total de registros
    public static function total($columna = '', $valor = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if ($columna) {
            $query .= " WHERE ${columna} = '${valor}'";
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();

        return array_shift($total);
    }

    // Total de Registros con un Array Where
    public static function totalArray($array = []) {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";
        foreach ($array as $key => $value) {
            if ($key == array_key_last($array)) {
                $query .= " ${key} = '${value}' ";
            } else {
                $query .= " ${key} = '${value}' AND ";
            }
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    }

    // Consulta SQL con JOIN
    public static function consultarConJoin($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjetoConJoin($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Consulta SQL con JOIN de forma dinámica
    public static function consultarConJoinDinamico($query, $clase) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Verificar si hay resultados
        if (!$resultado) {
            die('Error al ejecutar la consulta: ' . self::$db->error);
        }

        // Iterar los resultados y crear objetos de la clase especificada
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $objeto = static::crearObjetoConJoin($registro, $clase);
            $array[] = $objeto;
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crear objeto con datos de JOIN
    protected static function crearObjetoConJoin($registro) {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // crea un nuevo registro con datos de JOIN
    public function crearConJoin($tabla_join, $columnas_join, $valores_join) {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= ", " . $columnas_join . " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ', '" . $valores_join . "')";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro con datos de JOIN
    public function actualizarConJoin($columnas_join, $valores_join) {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);
        $query .= ", " . $columnas_join . " = '" . $valores_join . "' ";
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID con JOIN
    public function eliminarConJoin() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Método para inactivar un registro por su ID
    public function inactivar($columna) {
        $query = "UPDATE " . static::$tabla . " SET ${columna} = '0' WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Método para inactivar un registro por su ID
    public function eliminar($columna) {
        $query = "UPDATE " . static::$tabla . " SET ${columna} = '0' WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    //Elimina pero solo desactiva dependiendo del estatus estatico de los campos a corde a la comlumna
    // En ActiveRecord.php
    public static function deshabilitar($id, $columna) {
        $db = self::$db;
        $id = $db->escape_string($id);
        $columna = $db->escape_string($columna);
        $query = "UPDATE " . static::$tabla . " SET ${columna} = '0' WHERE id = '${id}' LIMIT 1";
        $resultado = $db->query($query);
        return $resultado;
    }





    public static function countByColumn($table, $column, $value) {
        $query = "SELECT COUNT(*) FROM {$table} WHERE {$column} = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $value);
        $stmt->execute();
        
        if ($stmt->errno) {
            // Manejo de errores
            echo "Error: " . $stmt->error;
            return false;
        }
        
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        
        return $count;
    }

    // Busca un registro por su id sin errores al usar depuración
    public static function findId($id) {
        if (!is_numeric($id)) {
            return null; // Retornar null si el ID no es un número válido
        }
    
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ? LIMIT 1";
        
        // Usar la conexión a la base de datos para preparar la consulta
        $stmt = self::$db->prepare($query);
        
        if (!$stmt) {
            // Manejo de errores
            echo "Error al preparar la consulta: " . self::$db->error;
            return null;
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado && $resultado->num_rows > 0) {
            // Obtener el registro como array asociativo
            $registro = $resultado->fetch_assoc();
            // Crear una instancia de la clase y asignar los valores del registro
            $objeto = new static();
            foreach ($registro as $campo => $valor) {
                $objeto->$campo = $valor;
            }
            return $objeto; // Retornar el objeto con todos los campos
        }
    
        return null; // Retornar null si no se encontró ningún registro
    }

    // Método para obtener el primer registro
    public static function first($query) {
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }


    public static function findByPacienteId($pacienteId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE paciente_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $pacienteId);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            return new static($datos); // Suponiendo que el constructor acepta un array de datos
        }
        
        return new static(); // Devuelve una nueva instancia si no hay resultados
    }
    
    
    
    
    // Método estático para crear una instancia del modelo a partir de un array asociativo
    public static function fromArray(array $data) {
        $instance = new self(); // Cambia a `new self()` para utilizar la clase actual
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }
        return $instance;
}

    // Transacciones de BD
    public static function beginTransaction() {
        self::$db->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
    }

    public static function commit() {
        self::$db->commit();
    }

    public static function rollback() {
        self::$db->rollback();
    }
    
}