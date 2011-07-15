<?php

$sourcematrix=new DOMImplementation;

include "motor.php";
include "controles.php";

$dtd=$sourcematrix->createDocumentType('html','-//W3C//DTD XHTML 1.0 Strict//EN','http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');
$document=$sourcematrix->createDocument("","",$dtd);
$document->encoding='UTF-8';

$html=$document->createElement('html');
$html->setAttribute('xmlns','http://www.w3.org/1999/xhtml');
$html->setAttribute('xml:lang','en');
$html->setAttribute('lang','es');
$document->appendChild($html);
$head=$document->createElement('head');
$html->appendChild($head);
$body=$document->createElement('body');
$html->appendChild($body);

$title=$document->createElement('title');
$title->appendChild($document->createTextNode($titulo));
$head->appendChild($title);

$divquest=$document->createElement('div');
$body->appendChild($divquest);
$divquest->setAttribute('class','quest');
$h1titulo=$document->createElement('h1');
//$h1titulo->setAttribute();
$h1titulo->appendChild($document->createTextNode($tituloPagina));
$divquest->appendChild($h1titulo);

if(!isset($_POST['alumno']))
	$divquest->appendChild(opnqst_empezando($document));
else{
	$data=array('preguntas'=>$preguntas,'alumno'=>$_POST['alumno'],'temas'=>$subjects);
	$divquest->appendChild(opnqst_prueba($document,$data));
}
echo $document->saveXML();
