<?php

class Topenqst_Block_prueba {

function build($data){
	$thesource=new DOMImplementation;
	$document=$thesource->createDocument();
	$block=$document->createElement('div');
	$formprueba=$document->createElement('form');
	$block->appendChild($formprueba);
	$formprueba->setAttribute('method','post');
	$formprueba->setAttribute('action','#');
	$h1nombre=$document->createElement('h1');
	$formprueba->appendChild($h1nombre);
	$h1nombre->appendChild($document->createTextNode($data['alumno']));
	foreach($data['preguntas'] as $tema=>$pregtem){
		$fieldsettema=$document->createElement('fieldset');
		$formprueba->appendChild($fieldsettema);
		$legendtema=$document->createElement('legend');
		$fieldsettema->appendChild($legendtema);
		$legendtema->appendChild($document->createTextNode("Tema ".$data['temas'][$tema]));
		foreach($pregtem as $no => $pregunta){
			$fieldsetpreg=$document->createElement('fieldset');
			$fieldsettema->appendChild($fieldsetpreg);
			$legendpregunta=$document->createElement('legend');
			$fieldsetpreg->appendChild($legendpregunta);
			$legendpregunta->appendChild($document->createTextNode("Pregunta ".($no+1)));
			$ppregunta=$document->createElement('p');
			$fieldsetpreg->appendChild($ppregunta);
			$ppregunta->appendChild($document->createTextNode($pregunta['q']));
			unset($pregunta['q']);
			foreach($pregunta as $posibilidad){
				$inputpos=$document->createElement('input');
				$fieldsetpreg->appendChild($inputpos);
				$inputpos->setAttribute('class','posibilidades');
				$inputpos->setAttribute('type','radio');
				$inputpos->setAttribute('name',$tema.'_'.($no+1));
				$inputpos->setAttribute('value',$posibilidad);
				$inputpos->appendChild($document->createTextNode($posibilidad));
			}
		}
	}
	$buttonlisto=$document->createElement('button');
	$formprueba->appendChild($buttonlisto);
	$buttonlisto->setAttribute('id','listo');
	$buttonlisto->setAttribute('type','submit');
	$buttonlisto->setAttribute('name','listo');
	$buttonlisto->setAttribute('value','true');
	$buttonlisto->appendChild($document->createTextNode('ya ta'));
	$buttonreset=$document->createElement('button');
	$formprueba->appendChild($buttonreset);
	$buttonreset->setAttribute('id','borratodo');
	$buttonreset->setAttribute('type','reset');
	$buttonreset->appendChild($document->createTextNode('empezar desde 0'));
	return $block;
}

}
