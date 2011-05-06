<?php

$db=array(
		"culturageneral"=>array(
			array('q'=>'quien la tiene más grande?',0=>'el dibu','el vocal','el guitar'),
			array('q'=>'cuantas vidas tiene un gato?',0=>'una','siete','aun es un misterio'),
			array('q'=>'de que país es aladino?',0=>'de china','de arabia','de agrabad'),
			array('q'=>'que oficio tenía el papa de pinocho?',0=>'carpintero','amo de casa','constructor de marionetas'),
			array('q'=>'cual es el planeta que más se parece a la tierra?',0=>'venus','europa','marte'),
			),
		"matematicabasica"=>array(
			array('q'=>'cuanto es dos más dos?',0=>'4','0','5'),
			array('q'=>'cuanto es tres elevado a la cuatro?',0=>'81','27','57'),
			array('q'=>'cuanto es dos por dos?',0=>'4','1','2'),
			array('q'=>'cuanto es dos más dos?',0=>'4','0','5'),
			),
		 );
$doc=new DOMDocument();
$source=$doc->createElement('source');
$doc->appendChild($source);
foreach($db as $tem=>$pregstem){
	$tema=$doc->createElement('tema');
	$source->appendChild($tema);
	$tema->setAttribute('nombre',$tem);
	foreach($pregstem as $pregunta){
		$lapreg=$doc->createElement('pregunta');
		$tema->appendChild($lapreg);
		foreach($pregunta as $no=>$opcion){
			if(!is_int($no))
				$txt=$doc->createElement('texto');
			else
				$txt=$doc->createElement('opcion');
			$lapreg->appendChild($txt);
			$txt->appendChild($doc->createTextNode($opcion));
			if(is_int($no))
				if($no==0)
					$txt->setAttribute('respuesta','true');
		}
	}
}
$doc->save('preguntas.xml');
?>