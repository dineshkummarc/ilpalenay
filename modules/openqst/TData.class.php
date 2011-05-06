<?php

class TOpenQst_Data {
	
private $thesource;
public $ok;
	
function __construct(){
	$this->thesource=new DOMImplementation;
	$this->sofar();
}

function __destruct(){
}

function sofar(){
	$this->curso='paralavida';
	$this->subjects=$this->opnqst_subjectlist($this->curso);
	$this->titulo="Prueba :: ".$this->curso." :: ".$alumno;
	$this->tituloPagina="Prueba de ".$this->curso;

	$this->preguntas=array();
	$this->temario=array();
	foreach($this->subjects as $key=>$subject){
		$this->preguntas[$key]=array();
		$this->temario[$key]=array();
		for ($i=0;$i<3;$i++){
			while (in_array($thisid=mt_rand(0,$this->opnqst_questioncont($key)-1),$this->temario[$key]))
				$thisid;
			$this->preguntas[$key][$i]=$this->opnqst_question($key,$thisid);
			$this->temario[$key][]=$thisid;
		}
	}

	asort($this->temario);
	$this->opnqst_wrtemario($this->temario);
	$this->data=array('preguntas'=>$this->preguntas,'alumno'=>$alumno,'temas'=>$this->subjects);
}

function opnqst_subjectlist($questionaryid){
	$questionaries=$this->thesource->createDocument();
	$questionaries->load('datasource/openqst/preguntas.xml');
	$questionaries->validate();
	$questionary=$questionaries->getElementById($questionaryid);
	$domsubjects=$questionary->getElementsByTagName('subject');
	$subjects=array();
	for($i=0;$i<$domsubjects->length;$i++){
		$subjects[$domsubjects->item($i)->getAttribute('id')]=$domsubjects->item($i)->getAttribute('name');
	}
	return $subjects;
	//$subjectlist=array('Para la Vida'=>array(1=>'culturageneral',2=>'matematicabasica'),);
	//return $subjectlist[$course];
}

function db($subject){
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
	return $db[$subject];
}

function opnqst_questioncont($subject){
	return count($this->db($subject));
}

function opnqst_question($subject,$questionid){
	$origen=$this->db($subject);
	$preguntas=$origen[$questionid];
	$pregunta=$preguntas['q'];
	unset($preguntas['q']);
	shuffle($preguntas);
	$preguntas['q']=$pregunta;
	return $preguntas;
}

function opnqst_answer($subject,$questionid){
	$preguntas=$this->db($subject);
	return $preguntas[$questionid]["r"];
}

function opnqst_wrtemario($temario){
	//salvar $temario;
}

}
