<?php

$numerador = 0;

function numerar(){
 global $numerador;
 return "\n".++$numerador;
} 
