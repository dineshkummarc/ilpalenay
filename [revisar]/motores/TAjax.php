<?php

include 'TMotor_base.php';

class TMotor extends TMotor_base{
function mostrar($contenido){
 echo numerar()."- ".parent::mostrar($contenido)." Utilizo tecnología AJAX";	//Creación de algoritmo
}
} 
