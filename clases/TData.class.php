<?php

include_once('defaults.php');
include_once('config.php');

class TData {

private $thesource, $datasource;
public $state,$ok;

function __construct(){
	$this->thesource=new DOMImplementation;
	$this->datasource=new TDataSource(Default_DataSource_XMLFile_Path);
// 	$this->state=$this->thesource->createDocument();
}


function __destruct(){
	$this->datasource->saveElement('states','states',$this->state);
}

function loadState(){
	$state=$this->thesource->createDocument();
	$state->load($this->basedir.$this->tree->getElementById('state')->getAttribute('path'));
	return $state->saveXML();
}

function saveState($XMLStream){
	$state=$this->thesource->createDocument();
	$state->loadXML($XMLStream);
	return $state->save($this->basedir.$this->tree->getElementById('state')->getAttribute('path'));
}


} 
 
