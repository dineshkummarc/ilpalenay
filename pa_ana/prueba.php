<?php

$sourcematrix=new DOMImplementation;

include 'motor.php';

echo $qstsources->saveXML(); 

$cursos=$qstsources->getElementsByTagName('curso');

echo $cursos->length;

for($i=0;$i<$cursos->length;$i++){
	if($cursos->item($i)->getAttribute('nombre')==$curso){
		$temas=$cursos->item($i)->getElementsByTagName('tema');
		for($j=0;$j<$temas->length;$j++){
			$pregs=$sourcematrix->createDocument();
			$pregs->load('preguntas/'.$temas->item($j)->getAttribute('nombre').'.xml');
		}
		break;
	}
}

echo $pregs->saveXML();