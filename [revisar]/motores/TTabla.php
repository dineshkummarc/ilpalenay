<?php

class TMotor extends TMotor_base{
function mostrar($contenido){
 parent::mostrar($contenido);
 echo numerar()."- ".parent::mostrar($contenido)." Utilizo tablas para armar el muñeco.";	//Creación de algoritmo
}
} 
