<?php

function opnqst_empezando($doc){
	$formnombre=$doc->createElement('form');
	$formnombre->setAttribute('method','post');
	$formnombre->setAttribute('action','#');
	$labelnombre=$doc->createElement('label');
	$formnombre->appendChild($labelnombre);
	$labelnombre->setAttribute('for','inputnombre');
	$labelnombre->appendChild($doc->createTextNode('Nombre:'));
	$inputnombre=$doc->createElement('input');
	$formnombre->appendChild($inputnombre);
	$inputnombre->setAttribute('id','inputnombre');
	$inputnombre->setAttribute('type','text');
	$inputnombre->setAttribute('name','alumno');
	$botonsoyyo=$doc->createElement('button');
	$formnombre->appendChild($botonsoyyo);
	$botonsoyyo->setAttribute('type','submit');
	$botonsoyyo->appendChild($doc->createTextNode('Este soy yo'));
	return $formnombre;
}

function opnqst_prueba($doc,$data){
	$formprueba=$doc->createElement('form');
	$formprueba->setAttribute('method','post');
	$formprueba->setAttribute('action','#');
	$h1nombre=$doc->createElement('h1');
	$formprueba->appendChild($h1nombre);
	$h1nombre->appendChild($doc->createTextNode($data['alumno']));
	$inputnombre=$doc->createElement('input');
	$formprueba->appendChild($inputnombre);
	$inputnombre->setAttribute('id','inputnombre');
	$inputnombre->setAttribute('type','hidden');
	$inputnombre->setAttribute('name','alumno');
	$inputnombre->setAttribute('value',$data['alumno']);
	$buttonnosoy=$doc->createElement('button');
	$formprueba->appendChild($buttonnosoy);
	$buttonnosoy->setAttribute('type','submit');
	$buttonnosoy->setAttribute('name','otroalumno');
	$buttonnosoy->setAttribute('value','true');
	$buttonnosoy->appendChild($doc->createTextNode('Este no soy yo'));
	foreach($data['preguntas'] as $tema=>$pregtem){
		$fieldsettema=$doc->createElement('fieldset');
		$formprueba->appendChild($fieldsettema);
		$legendtema=$doc->createElement('legend');
		$fieldsettema->appendChild($legendtema);
		$legendtema->appendChild($doc->createTextNode("Tema ".$data['temas'][$tema]));
		foreach($pregtem as $no => $pregunta){
			$fieldsetpreg=$doc->createElement('fieldset');
			$fieldsettema->appendChild($fieldsetpreg);
			$legendpregunta=$doc->createElement('legend');
			$fieldsetpreg->appendChild($legendpregunta);
			$legendpregunta->appendChild($doc->createTextNode("Pregunta ".($no+1)));
			$ppregunta=$doc->createElement('p');
			$fieldsetpreg->appendChild($ppregunta);
			$ppregunta->appendChild($doc->createTextNode($pregunta['q']));
			unset($pregunta['q']);
			foreach($pregunta as $posibilidad){
				$inputpos=$doc->createElement('input');
				$fieldsetpreg->appendChild($inputpos);
				$inputpos->setAttribute('class','posibilidades');
				$inputpos->setAttribute('type','radio');
				$inputpos->setAttribute('name',$tema.'_'.($no+1));
				$inputpos->setAttribute('value',$posibilidad);
				$inputpos->appendChild($doc->createTextNode($posibilidad));
			}
		}
	}
	$buttonlisto=$doc->createElement('button');
	$formprueba->appendChild($buttonlisto);
	$buttonlisto->setAttribute('id','listo');
	$buttonlisto->setAttribute('type','submit');
	$buttonlisto->setAttribute('name','listo');
	$buttonlisto->setAttribute('value','true');
	$buttonlisto->appendChild($doc->createTextNode('ya ta'));
	$buttonreset=$doc->createElement('button');
	$formprueba->appendChild($buttonreset);
	$buttonreset->setAttribute('id','borratodo');
	$buttonreset->setAttribute('type','reset');
	$buttonreset->appendChild($doc->createTextNode('empezar desde 0'));
	
	return $formprueba;

}