<?php

namespace Model;

class Category extends ActiveRecord {

    protected static $tabla = 'categorys';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

}