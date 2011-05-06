<?php

class TFuncionalidad {

public $modulo, $funcionalidad, $estado;

function __construct($modulo,$funcionalidad){
 $this->modulo = $modulo;
 $this->funcionalidad = $funcionalidad;
}

function ejecutar(){
 include "../modulos/".$this->modulo."/datos.php";
 return call_user_func(array("T".$this->modulo.'_datos',$this->funcionalidad));
}

function correr($ptrestado){
 $ptrestado = $this->ejecutar($ptrestado);
}


} 
