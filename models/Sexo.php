<?php

namespace Model;

class Sexo extends ActiveRecord {

    protected static $tabla = 'sexo';
    protected static $columnasDB = ['id', 'sexo'];

    public $id;
    public $sexo;

    public static function find($id) {
        $id = intval($id); // Asegúrate de que el ID es un entero
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id} LIMIT 1";
        $resultado = static::consultarSQL($query);
        return array_shift($resultado); // Devuelve el primer resultado (o null si no hay resultados)
    }
}