<?php

class Composer {

private $thesource,$head;
public $ok,$document,$body;

function __construct(){
	$this->thesource=new DOMImplementation;
	$dtd=$this->thesource->createDocumentType('html','-//W3C//DTD XHTML 1.0 Strict//EN','http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');
	$this->document=$this->thesource->createDocument("","",$dtd);
	$this->document->encoding='UTF-8';
	$html=$this->document->createElement('html');
	$html->setAttribute('xmlns','http://www.w3.org/1999/xhtml');
	$html->setAttribute('xml:lang','en');
	$html->setAttribute('lang','es');
	$this->document->appendChild($html);
	$this->head=$this->document->createElement('head');
	$html->appendChild($this->head);
	$this->body=$this->document->createElement('body');
	$html->appendChild($this->body);
}

function __destruct(){
}

function appendBlock($block){
	$importedblock=$this->document->importNode($block,true);
	$this->body->appendChild($importedblock);
}

function enableBlock($blockname,$data){
	$modulo=substr($blockname,0,strpos($blockname,'_'));
	$blockname=substr($blockname,strpos($blockname,'_')+1,strlen($blockname));
	eval('$this->appendBlock(T'.$modulo.'_Block_'.$blockname.'::build($data));');
}

function sendXML(){
	echo $this->document->saveXML();
}

} 
