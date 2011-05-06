<?php

class TNucleo {
private $funcionalidad, $estado;
public $roles,$compositor;

function __construct(){
 $this->roles = new TRoles();
 $this->cargarfunc();
 $this->estado = array();
}

private function cargarfunc(){
 echo numerar()."-Cargo las funcionalidades desde la base de datos";	//Creación de algoritmo
 $this->funcionalidad = array(new TFuncionalidad('nucleo','actualizarmod'));
 $this->funcionalidad[] = new TFuncionalidad('prueba','funcionalidaddeprueba');
}

public function actualizarmod(){
 $this->limpiarmod();
 echo numerar()."-Ciclo por todas los directorios dentro de 'modulos' agrego los módulos (limpio la tabla de módulos y la vuelvo a llenar)";	//Creación de algoritmo
}

public function ejecutar($funcionalidad){
 foreach($this->funcionalidad as $func)
  if($func->funcionalidad == $funcionalidad)
   return $func->ejecutar(&$estado[$func->modulo]);
}

public function solicitud($funcionalidad){
 echo numerar()."-Verifico que el usuario (la sesión) pueda ejecutar la funcionalidad";	//Creación de algoritmo
 
 echo numerar()."-Llamo la funcionalidad";	//Creación de algoritmo
 foreach($this->funcionalidad as $func)
  if($func->funcionalidad == $funcionalidad){
   include "../modulos/".$func->modulo."/datos.php";
   eval('$modulo = new '."T".$func->modulo.'_datos(&$estado[$func->modulo]);');
  }
 echo numerar()."-Le doy el 'control' al compositor";	//Creación de algoritmo
 #$this->compositor = new TCompositor();
 #$this->compositor->control($this->funcionalidad,$this->estado);
}

}