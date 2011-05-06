<?php

/*
---------------------------
TAAA.class.php
---------------------------
Version 0.2.2.0
Dependencias:
- TDataSource	0.2.4.0

TAAA pretende ser la clase que implementa los servicios AAA. Debe realizar todas
las operaciones AAA y los chequeos en las operaciones y los eventos dentro del
nucleo.
*/

include_once('defaults.php');
include_once('config.php');

class TAAA {

private $thesource, $classdoc, $datasource;
public $ok, $user, $session;

function __construct(){
	$this->thesource=new DOMImplementation;
	$this->classdoc=$this->thesource->createDocument();
	$this->datasource=new TDataSource(Default_AAA_XMLFile_Path);
	if(isset($_COOKIE[Cookie_ID_Name])&&isset($_COOKIE[Cookie_SID_Name]))
		if($this->user=$this->loadUser($_COOKIE[Cookie_ID_Name]))
			  $this->continueSession($_COOKIE[Cookie_SID_Name]);
}

function __destruct(){
	if($this->user){
		$this->saveUser($this->user);
		$this->saveSession($this->user->getAttribute('id'),$this->session);
	}
}


//-------------------------------------- GENERAL FUNCTIONS -----------------------------------------------


//User related functions

private function createUser($userdata){
	$user=$this->classdoc->createElement('user');
	$user->setAttribute('id','uid'.hash('md5',$userdata['username']));
	$user->setAttribute('username',$userdata['username']);
	$user->setAttribute('password','sha512;'.hash('sha512',$userdata['password']));
	$user->setAttribute('creation_date',time());
	$user->setAttribute('last_login',false);
	$user->setAttribute('last_logout',false);
	$user->setAttribute('logged',0);
	return $user;
}

private function loadUser($userid){
	return $this->datasource->loadElement('users0','users0',$userid);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'users0'
}

private function saveUser($user){
	return $this->datasource->saveElement('users0','users0',$user);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'users0'
}

private function replaceUser($old_user_id,$newuser){
}

private function removeUser($userid){
	return $this->datasource->removeElement('users0','users0',$userid);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'users0'
}

//Advanced User related functions

private function authenticateUser($username,$password){
	if($user=$this->loadUser('uid'.hash('md5',$username)))
		if(0==strcasecmp($username,$user->getAttribute('username'))&&(0==strcmp('sha512;'.hash('sha512',$password),$user->getAttribute('password')))){
			$user->setAttribute('last_login',time());
			$user->setAttribute('logged',1);
			return $user;
		}
	return false;
}

private function deauthenticateUser($user){
	if($user->getAttribute('logged')==1){
		$user->setAttribute('last_logout',time());
		$sessions=$this->loadSessions($user->getAttribute('id'));
		if(!$test=$sessions->hasChildNodes()){
			$user->setAttribute('logged',0);
			return true;
		}	
	}
	return false;
}

//Session related functions

private function createSession($userid,$livetime){
	$session=$this->classdoc->createElement('session');
	$session->setAttribute('id','sid'.hash('sha256',time().$userid));
	$session->setAttribute('begin_date',time());
	$session->setAttribute('last_update',time());
	$session->setAttribute('livetime',$livetime);
	return $session;
}

private function loadSession($userid,$sid){
	return $this->datasource->loadElement('sessions0',$userid,$sid);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'sessions0'
}

private function saveSession($userid,$session){
	return $this->datasource->saveElement('sessions0',$userid,$session);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'sessions0'
}

private function replaceSession(){
}

private function removeSession($userid,$sid){
	if($session=$this->loadSession($userid,$sid))
		return $this->datasource->removeElement('sessions0',$userid,$sid);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'sessions0'
	return false;
}

//Advanced Session related functions

function refreshSession($userid,$sid){
	if($session=$this->loadSession($userid,$sid)){
		if($session->getAttribute('livetime')==0 || time()-$session->getAttribute('last_update')<$session->getAttribute('livetime')){
			  $session->setAttribute('last_update',time());
			  return $session;
		}
		else
			  $this->removeSession($userid,$sid);
	}
	return false;
}

//Sessions related functions

private function createSessions($userid){
	$sessions=$this->classdoc->createElement('sessions');
	$sessions->setAttribute('id',$userid);
	return $sessions;
}

private function loadSessions($userid){
	return $this->datasource->loadElement('sessions0','sessions0',$userid);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'sessions0'
}

private function saveSessions($sessions){
	return $this->datasource->saveElement('sessions0','sessions0',$sessions);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'sessions0'
}

private function replaceSessions($userid){
}

private function removeSessions($userid){
	if($sessions=$this->loadSessions($userid)){
		for($i=0;$i<$sessions->childNodes->length;$i++)
			 $this->removeSession($userid,$sessions->childNodes->item($i)->getAttribute('id'));
		return $this->datasource->removeElement('sessions0','sessions0',$userid);	//Revisar como implementar las diferentes fuentes de datos, en este caso fijado 'sessions0'
	}
	return false;
}

//Advanced Sessions related functions

private function cleanSessions($userid){
	if($sessions=$this->loadSessions($userid)){
		for($i=0;$i<$sessions->childNodes->length;$i++)
			if($sessions->childNodes->item($i)->getAttribute('last_update')+$sessions->childNodes->item($i)->getAttribute('livetime')<time())
				$this->endSession($sessions->childNodes->item($i)->getAttribute('id'));
		return true;
	}
	return false;
}

//-------------------------------------------Explicit Class functions------------------------------------

function addUser($userdata){
	if(!$this->loadUser('uid'.hash('md5',$userdata['username']))){
		$this->user=$this->createUser($userdata);
		$this->saveSessions($this->createSessions($this->user->getAttribute('id')));
		return true;
	}
	return false;
}

function dropUser($username){
	if($user=$this->loadUser('uid'.hash('md5',$username))){
		$this->removeSessions($user->getAttribute('id'));
		$this->removeUser($user->getAttribute('id'));
		return true;
	}
	return false;
}

private function startSession($livetime){
	if(!$this->loadSession($this->user->getAttribute('id'),'sid'.hash('sha256',time().$this->user->getAttribute('id')))){
		$this->session=$this->createSession($this->user->getAttribute('id'),$livetime);
	}
}

private function continueSession($sid){
	$this->session=$this->refreshSession($this->user->getAttribute('id'),$sid);
}

private function endSession($sid){
	$this->removeSession($this->user->getAttribute('id'),$sid);
	if(isset($this->session->tagName))
		if(0==strcmp($this->session->getAttribute('id'),$sid))
			$this->session=null;

}


function logIn($username,$password){
	if($this->user=$this->authenticateUser($username,$password)){
		$this->cleanSessions($this->user->getAttribute('id'));
		if($this->loadSessions($this->user->getAttribute('id'))->childNodes->length<Default_Session_Max_Count){
			$this->startSession(Default_Session_Livetime);
			setcookie(Cookie_ID_Name,$this->user->getAttribute('id'),Cookie_ID_Time);
			setcookie(Cookie_SID_Name,$this->session->getAttribute('id'),Cookie_SID_Time);
			return true;
			}
	}
	return false;
}

function logOut(){
	if(isset($this->user->tagName))
		if(isset($this->session->tagName)){
			$this->endSession($this->session->getAttribute('id'));
			$this->deauthenticateUser($this->user);
			setcookie(Cookie_ID_Name,'');
			setcookie(Cookie_SID_Name,'');
			return true;
		}
	return false;
}

} 
