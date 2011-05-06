<?php 

class TCompositor{

private $contenido;

function __construct($estado){
 
 echo numerar()."-Llamo al método que crea contenido para el nucleo";	//Creación de algoritmo
 $alnucleo = array();
 foreach($funcionalidad as $func)
  if($func->modulo == '')
   $alnucleo[]=$func;
 $this->nucleo_compositor($alnucleo);
}

private function nucleo_compositor($alnucleo){
 
}

function control(){
 
 echo numerar()."-Llamo la funcionalidad que crea contenido para el estado actual";	//Creación de algoritmo
 echo numerar()."-Llamo al motor de dibujo pasándole el contenido";	//Creación de algoritmo
 TMotor::mostrar($this->contenido);
}

}