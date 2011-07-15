<?php

/*
---------------------------
xml.php
---------------------------
Version 0.0.0.1

Wrapper for the XML store method.
*/

class StoreXML {

	private $thesource, $path, $document, $hasChanged;
	public $ok;
	
	function __construct($path){
		$this->hasChanged=False;
		$this->path=$path;
		if(file_exists($this->path)){
			$this->thesource=new DOMImplementation;
			$this->document=$this->thesource->createDocument();
			$this->document->load($this->path);
			$this->ok['document']=$this->document->validate();
		}
	}

	function __destruct(){
		if($this->hasChanged){
			$this->document->save($this->path);
			}
	}

	function createStore($document){
		$this->document=$document;
		$this->hasChanged=True;
	}
	
	function loadUser($userid){
		$users=$this->document->getElementsByTagName('users');
		$users=$users->item(0);
		if($users->hasAttribute('path'))
			if(file_exists($path=$users->getAttribute('path'))){
				$users_file=$this->thesource->createDocument();
				$users_file->load($path);
				$users_imported=$this->document->importNode($users_file->documentElement,True);
				$users->parentNode->replaceChild($users_imported,$users);
				$this->ok['document']=$this->document->validate();
			}
		if($userid){
			return $this->document->getElementById($userid);
		}
	}
	
	function saveUser($user){
		if($parent=$this->document->getElementsByTagName('users')->item(0)){
			$old=$this->document->getElementById($user->getAttribute('id'));
			$the=$this->document->importNode($user,true);
			if($old){
				if($old->parentNode==$parent)
					$old->parentNode->replaceChild($the,$old);
			}
			else
				$parent->appendChild($the);
			$this->hasChanged=True;
			return True;
		}
		return False;
	}
	
	function removeUser($user_id){
		$parent=$this->document->getElementsByTagName('users')->item(0);
		$user=$this->document->getElementById($user_id);
		if($parent&&$user)
			if($user->parentNode==$parent){
				$parent->removeChild($user);
				$this->hasChanged=True;
				return true;
			}
		return false;
	
	}
	
	function loadElement($parent_class,$element_id){
		if($parent=$this->document->getElementsByTagName($parent_class))
			if($element=$this->document->getElementById($element_id))
				if($element->parentNode==$parent)
					return $element;
		return false;
	}
	
}