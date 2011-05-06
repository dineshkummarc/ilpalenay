<?php

/*
---------------------------
TDataSource.class.php
---------------------------
Version 0.2.1.0

TDataSource pretende ser la clase de abstracción de datos, no se deben usar
varias clases (generalmente se utiliza 1 por controlador) sino que se utilizan
los diferentes wrappers dentro de las diferentes funciones y mediante hojas XSLT
hacer las transformaciones pertinentes para los diferentes gestores.
*/

include_once('defaults.php');
include_once('config.php');

class TDataSource {
	
private $thesource, $basedir, $path, $secret, $hasChange;
public $sources, $ok;
	
function __construct($path_to_secret){
	$this->path=$path_to_secret;
	$this->basedir=BaseDir;	//Revisar como no tener que utilizar direcciones absolutas
	$this->thesource=new DOMImplementation;
	$this->secret=$this->thesource->createDocument();
	$this->secret->load($this->basedir.$this->path);
	$this->ok['secret']=$this->secret->validate();
}

function __destruct(){
	$this->secret->save($this->basedir.$this->path);
	if(count($this->sources)>0)
		foreach($this->sources as $source_id => $thesource)
			$this->saveSource($source_id);
}

private function loadSource($source_id){
	if(isset($this->sources[$source_id])) return true;
	$this->sources[$source_id]=$this->thesource->createDocument();
	$this->sources[$source_id]->load($this->basedir.$this->secret->getElementById($source_id)->getAttribute('path'));
	$this->ok['source_'.$source_id]=$this->sources[$source_id]->validate();
	$this->hasChange[$source_id]=0;
}

private function saveSource($source_id){
	if($this->hasChange[$source_id]==1)
	      return $this->sources[$source_id]->save($this->basedir.$this->secret->getElementById($source_id)->getAttribute('path'));
}

private function newXMLFileSource($source_id){
	$dtd=$this->thesource->createDocumentType('xmlfile','',SystemDTD);
	$filedoc=$this->thesource->createDocument("","",$dtd);
	$filedoc->encoding='UTF-8';
	$file=$filedoc->createElement('xmlfile');
	$file->setAttribute('id',$source_id);
	$filedoc->appendChild($file);
	$filedoc->save($this->basedir.$this->secret->getElementById($source_id)->getAttribute('path'));
}

function addSource($sourcedata){
	if($this->secret->getElementById($sourcedata['id'])) return false;
	$source=$this->secret->createElement($sourcedata['type']);
	$source->setAttribute('id',$sourcedata['id']);
	$source->setAttribute('path',$sourcedata['path']);
	$this->secret->documentElement->appendChild($source);
	if(!file_exists($this->basedir.$this->secret->getElementById($sourcedata['id'])->getAttribute('path')))
	      $this->newXMLFileSource($sourcedata['id']);
}

function removeSource($source_id){
	if(!$this->secret->getElementById($source_id)) return false;
	return $this->secret->getElementById($source_id)->parentNode->removeChild($this->secret->getElementById($source_id));
}

function purgeSource($source_id){
	if(file_exists($this->secret->getElementById($source_id)->getAttribute('path')))
	  unlink($this->secret->getElementById($source_id)->getAttribute('path'));
	$this->removeSource($source_id);
}

function getSources(){
	$sources=array();
	for($i=0;$i<$this->secret->documentElement->childNodes->length;$i++)
	  $sources[$this->secret->documentElement->childNodes->item($i)->getAttribute('id')]=$this->secret->documentElement->childNodes->item($i);
	return $sources;
}

function loadElement($source_id,$parent_id,$element_id){
	$this->loadSource($source_id);
	if($parent=$this->sources[$source_id]->getElementById($parent_id))
		if($element=$this->sources[$source_id]->getElementById($element_id))
			if($element->parentNode==$parent)
				return $element;
	return false;
}

function saveElement($source_id,$parent_id,$element){
	if(isset($element->ownerDocument)){
		$this->loadSource($source_id);
		if($parent=$this->sources[$source_id]->getElementById($parent_id)){
			$oldelement=$this->sources[$source_id]->getElementById($element->getAttribute('id'));
			$theelement=$this->sources[$source_id]->importNode($element,true);
			if($oldelement){
				if($oldelement->parentNode==$parent)
					$oldelement->parentNode->replaceChild($theelement,$oldelement);
			}
			else
				$parent->appendChild($theelement);
			$this->hasChange[$source_id]=1;
			return true;
		}
	}
	return false;
}

function replaceElement($source_id,$parent_id,$old_element_id,$new_element){
	if(isset($new_element->ownerDocument)){
		$this->loadSource($source_id);
		if($parent=$this->sources[$source_id]->getElementById($parent_id)){
			$oldelement=$this->sources[$source_id]->getElementById($old_element_id);
			$theelement=$this->sources[$source_id]->importNode($element,true);
			if($oldelement)
				if($oldelement->parentNode==$parent){
					$oldelement->parentNode->replaceChild($theelement,$oldelement);
					$this->hasChange[$source_id]=1;
					return $oldelement;
				}
		}
	}
	return false;
}

function removeElement($source_id,$parent_id,$element_id){
	$this->loadSource($source_id);
	$parent=$this->sources[$source_id]->getElementById($parent_id);
	$element=$this->sources[$source_id]->getElementById($element_id);
	if($element->parentNode==$parent){
	      $parent->removeChild($element);
	      $this->hasChange[$source_id]=1;
	      return true;
	}
	return false;
}

}
		