<?php

include 'fuentededatos.php';

//print_r($_POST);

if(isset($_POST['otroalumno']))
	if($_POST['otroalumno']==true)
		unset($_POST['alumno']);
$curso='paralavida';
$subjects=opnqst_subjectlist($curso);
$titulo="Prueba :: ".$curso." :: ".$alumno;
$tituloPagina="Prueba de ".$curso;

$preguntas=array();
$temario=array();
foreach($subjects as $key=>$subject){
	$preguntas[$key]=array();
	$temario[$key]=array();
	for ($i=0;$i<3;$i++){
		while (in_array($thisid=mt_rand(0,opnqst_questioncont($key)-1),$temario[$key]))
			$thisid;
		$preguntas[$key][$i]=opnqst_question($key,$thisid);
		$temario[$key][]=$thisid;
	}
}

asort($temario);
opnqst_wrtemario($temario);
