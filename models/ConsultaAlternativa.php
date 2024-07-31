<?php

namespace Model;

class ConsultaAlternativa extends ActiveRecord {

    protected static $tabla = 'c_terapia_alternativa';
    protected static $columnasDB = ['id', 'nombre', 'apellidos' , 'edad', 'sexo', 
    'peso', 'estatura', 'diabetes', 'cancer', 'obesidad' , 'depresion', 'infarto', 
    'estrinido', 'alergia', 'gastritis', 'artritis', 'chatarra', 
    'fumador', 'bebedor', 'cirujias', 'embarazos', 'abortos', 
    'expediente_file', 'presion', 'oximetro', 'glucosa', 
    'unas', 'sintoma_diagnostico', 'r_corazon', 'r_rinon', 'r_cerebro', 
    'r_estomago', 'r_huesos','tratamiento', 'estatus', 'fecha_creacion', 'fecha_modificacion', 
    'fecha_eliminacion', 'usuario_id', 'url_avance'];


    public $id;
    public $nombre;
    public $apellidos;
    public $edad;
    public $sexo;
    public $peso;
    public $estatura;
    public $diabetes;
    public $cancer;
    public $obesidad;
    public $depresion;
    public $infarto;
    public $estrinido;
    public $alergia;
    public $gastritis;
    public $artritis;
    public $chatarra;
    public $fumador;
    public $bebedor;
    public $cirujias;
    public $embarazos;
    public $abortos;
    public $expediente_file;
    public $presion;
    public $oximetro;
    public $glucosa;
    public $unas;
    public $sintoma_diagnostico;
    public $r_corazon;
    public $r_rinon;
    public $r_cerebro;
    public $r_estomago;
    public $r_huesos;
    public $tratamiento;
    public $estatus;
    public $fecha_creacion;
    public $fecha_modificacion;
    public $fecha_eliminacion;
    public $usuario_id;
    public $url_avance;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->edad = $args['edad'] ?? '';
        $this->peso = $args['peso'] ?? '';
        $this->estatura = $args['estatura'] ?? '';
        $this->diabetes = $args['diabetes'] ?? '';
        $this->cancer = $args['cancer'] ?? '';
        $this->obesidad = $args['obesidad'] ?? '';
        $this->infarto = $args['infarto'] ?? '';
        $this->estrinido = $args['estrinido'] ?? '';
        $this->alergia = $args['alergia'] ?? '';
        $this->gastritis = $args['gastritis'] ?? '';
        $this->artritis = $args['artritis'] ?? '';
        $this->chatarra = $args['chatarra'] ?? '';
        $this->fumador = $args['fumador'] ?? '';
        $this->bebedor = $args['bebedor'] ?? '';
        $this->cirujias = $args['cirujias'] ?? '';
        $this->embarazos = $args['embarazos'] ?? '';
        $this->abortos = $args['abortos'] ?? '';
        $this->presion = $args['presion'] ?? '';
        $this->oximetro = $args['oximetro'] ?? '';
        $this->glucosa = $args['glucosa'] ?? '';
        $this->unas = $args['unas'] ?? '';
        $this->sintoma_diagnostico = $args['sintoma_diagnostico'] ?? '';
        $this->r_corazon = $args['r_corazon'] ?? '';
        $this->r_rinon = $args['r_rinon'] ?? '';
        $this->r_cerebro = $args['r_cerebro'] ?? '';
        $this->r_estomago = $args['r_estomago'] ?? '';
        $this->r_huesos = $args['r_huesos'] ?? '';
        $this->tratamiento = $args['tratamiento'] ?? '';
        $this->estatus = $args['estatus'] ?? 1;
        $this->url_avance = $args['url_avance'] ?? '';
        $this->expediente_file = $args['expediente_file'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? 'NOW()';
        $this->fecha_modificacion = $args['fecha_modificacion'] ?? 'NOW()';
        $this->fecha_eliminacion = $args['fecha_eliminacion'] ?? 'NOW()';
        $this->usuario_id = $args['usuario_id'] ?? '';
    }
    // Mensajes de validación para la creación de recursos de login etc.
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre(s) del Paciente son Obligatorios';
        }
        if(!$this->apellidos) {
            self::$alertas['error'][] = 'Los apellidos del paciente son Obligatorios';
        }
        if(!$this->edad) {
            self::$alertas['error'][] = 'La Edad del paciente es Obligatorio';
        }

        if(!$this->sexo) {
            self::$alertas['error'][] = 'El Genero del paciente es Obligatorio';
        }

        if(!$this->peso) {
            self::$alertas['error'][] = 'El Peso del paciente es Obligatorio';
        }
        if(!$this->expediente_file) {
            self::$alertas['error'][] = 'El examen medico del paciente es Obligatoria';
         }

        if(!$this->estatura) {
            self::$alertas['error'][] = 'La estatura del paciente es Obligatoria';
        }

        if(!$this->diabetes) {
            self::$alertas['error'][] = 'Elije el tipo de diabetes del paciente';
        }

        if(!$this->cancer) {
            self::$alertas['error'][] = 'Elije el tipo de cancer del paciente';
        }

        if(!$this->obesidad) {
            self::$alertas['error'][] = 'Elije el tipo de obesidad del paciente';
        }

        if(!$this->infarto) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->estrinido) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->alergia) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->gastritis) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->artritis) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->chatarra) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->fumador) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->bebedor) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->cirujias) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->embarazos) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->abortos) {
            self::$alertas['error'][] = 'Elije el tipo una opción';
        }

        if(!$this->presion) {
            self::$alertas['error'][] = 'La Presión arterial del paciente es obligatoria';
        }

        if(!$this->oximetro) {
            self::$alertas['error'][] = 'El resultado del oxímetro del paciente es obligatoria';
        }

        if(!$this->unas) {
            self::$alertas['error'][] = 'El estado de las uñas del paciente son obligatorios';
        }

        if(!$this->glucosa) {
            self::$alertas['error'][] = 'El resultado de la glucosa del paciente es obligatoria';
        }

        if(!$this->sintoma_diagnostico) {
            self::$alertas['error'][] = 'El Síntoma o Diagnóstico del paciente es obligatoria';
        }

        if(!$this->r_corazon) {
            self::$alertas['error'][] = 'El Resultado que arrrojo del Corazón de la Resonancia del paciente es obligatoria';
        }

        if(!$this->r_rinon) {
            self::$alertas['error'][] = 'El Resultado que arrrojo del Riñon de la Resonancia del paciente es obligatoria';
        }

        if(!$this->r_cerebro) {
            self::$alertas['error'][] = 'El Resultado que arrrojo del Cerebro de la Resonancia del paciente es obligatoria';
        }

        if(!$this->r_estomago) {
            self::$alertas['error'][] = 'El Resultado que arrrojo el estado del Cerebro de la Resonancia del paciente es obligatoria';
        }

        if(!$this->r_huesos) {
            self::$alertas['error'][] = 'El Resultado que arrrojo del estado Huesos de la Resonancia del paciente es obligatoria';
        }
        if(!$this->tratamiento){
            self::$alertas['error'][] = 'Ingrese el Tratamiento a seguir del paciente, es obligatorio!';
        }
        return self::$alertas;
    }
}