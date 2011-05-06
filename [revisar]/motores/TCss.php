<?php

include 'TMotor_base.php';

class TMotor extends TMotor_base{
function mostrar($contenido){
 parent::mostrar($contenido);
 echo numerar()."- ".parent::mostrar($contenido)." Utilizo hojas de estilo en cascada (css).";	//Creación de algoritmo
}
} 
 
