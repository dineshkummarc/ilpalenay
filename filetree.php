<?php

include_once('defaults.php');
include_once('config.php');

class FileTree {
	
private $thesource, $treedescriptor, $basedir;
public $tree, $ok;

function __construct(){
	$this->thesource=new DOMImplementation;
}

function __destruct(){
}

private function checkNewStart(){

}

private function newSecretAAA($path){
	$dtd=$this->thesource->createDocumentType('aaa','',SystemDTD);
	$aaadoc=$this->thesource->createDocument("","",$dtd);
	$aaadoc->encoding='UTF-8';
	$aaa=$aaadoc->createElement('aaa');
	$aaadoc->appendChild($aaa);
	$aaa->setAttribute('id','aaa');
	$aaadoc->validate();
	$aaadoc->save($path);
}

private function newSecretDatasource($path){
	$dtd=$this->thesource->createDocumentType('datasource','',SystemDTD);
	$datasourcedoc=$this->thesource->createDocument("","",$dtd);
	$datasourcedoc->encoding='UTF-8';
	$datasource=$datasourcedoc->createElement('datasource');
	$datasourcedoc->appendChild($datasource);
	$datasource->setAttribute('id','datasource');
	$datasourcedoc->validate();
	$datasourcedoc->save($path);
}

function checkFreshInstall(){
	if(!file_exists(Default_AAA_XMLFile_Path)) $this->newSecretAAA(Default_AAA_XMLFile_Path);
	$datasource=new DataSource(Default_AAA_XMLFile_Path);
	$sources=$datasource->getSources();
	if(!isset($sources['users0'])){
	      $users=array('type'=>'xmlfile','id'=>'users0','path'=>Default_Users_XMLFile_Path);
	      $datasource->addSource($users);
	}
	if(!isset($sources['acls0'])){
	      $acls=array('type'=>'xmlfile','id'=>'acls0','path'=>Default_ACLs_XMLFile_Path);
	      $datasource->addSource($acls);
	}
	if(!isset($sources['sessions0'])){
	      $sessions=array('type'=>'xmlfile','id'=>'sessions0','path'=>Default_Sessions_XMLFile_Path);
	      $datasource->addSource($sessions);
	}
	if(!file_exists(Default_DataSource_XMLFile_Path)) $this->newSecretDatasource(Default_DataSource_XMLFile_Path);
	$datasource=new DataSource(Default_DataSource_XMLFile_Path);
	$sources=$datasource->getSources();
	if(!isset($sources['sessions'])){
	      $states=array('type'=>'xmlfile','id'=>'sessions','path'=>Default_State_XMLFile_Path);
	      $datasource->addSource($states);
	}
}

}