<?php

/*
---------------------------
AAA.class.php
---------------------------
Version 0.3.0.0

AAA pretende ser la clase que implementa los servicios AAA. Debe realizar todas
las operaciones AAA y los chequeos en las operaciones y los eventos dentro del
nucleo.
*/

require_once 'defaults.php';
require_once 'config.php';
require_once 'wrappers/xml.php';

class User {
	
	private $chunk;
	public $hasChanged;
	
	function __construct($user_chunk){
		if(!$user_chunk) return False;
		$this->chunk=$user_chunk;
		$this->id=$this->chunk->getAttribute('id');
		$this->username=$this->chunk->getAttribute('username');
		$this->creation_date=$this->chunk->getAttribute('creation_date');
		$this->last_login=$this->chunk->getAttribute('last_login');
		$this->last_logout=$this->chunk->getAttribute('last_logout');
		$this->logged=$this->chunk->getAttribute('logged');
		$sessions=$this->chunk->getElementsByTagName('session');
		$this->sessions=Array();
		for($i=0;$i<$sessions->length;$i++)
			$this->sessions[$sessions->item($i)->getAttribute('id')]=new Session($sessions->item($i));
		$this->hasChanged=False;
	}
	
	function getSynced(){
		if($this->hasChanged){
			$this->chunk->setAttribute('last_login',$this->last_login);
			$this->chunk->setAttribute('last_logout',$this->last_logout);
			$this->chunk->setAttribute('logged',$this->logged);
			foreach ($this->sessions as $sid => $session){
				echo "sid is $sid<br>\n";
				var_dump($session);
				if($session->hasChanged){
					if($session_chunk=$this->chunk->ownerDocument->getElementById($sid))
						$this->chunk->replaceChild($session->getSynced(),$session_chunk);
					else
						$this->chunk->appendChild($session->getSynced());
				}
			}
			return $this->chunk;
		}
		else return False;
	}
	
	function logIn(){
		$this->last_login=time();
		$this->logged=True;
		$session_chunk=$this->createSession(Default_Session_Livetime);
		$this->sessions[$session_chunk->getAttribute('id')]=new Session($session_chunk);
		$this->hasChanged=True;
		return False;
	}
	
	function createSession($livetime){
		do{
			$sid='sid'.hash('sha256',time().rand());
		} while ($this->chunk->ownerDocument->getElementById($sid));
		$session=$this->chunk->ownerDocument->createElement('session');
		$session->setAttribute('id',$sid);
		$session->setAttribute('begin_date',time());
		$session->setAttribute('last_update',time());
		$session->setAttribute('livetime',$livetime);
		return $session;
	}
	
	function activeSessions(){
		return 0;
	}

}

class Session {
	
	private $chunk, $id, $begin_date, $livetime, $last_update;
	public $hasChanged;
	
	function __construct($session_chunk){
		$this->chunk=$session_chunk;
		$this->id=$session_chunk->getAttribute('id');
		$this->begin_date=$session_chunk->getAttribute('begin_date');
		$this->livetime=$session_chunk->getAttribute('livetime');
		$this->last_update=$session_chunk->getAttribute('last_update');
		$this->hasChanged=True;
	}
	
	function getSynced(){
		return $this->chunk;
	}
	
	function activateSession(){
		setcookie(Cookie_ID_Name,$this->id,Cookie_ID_Time);
		setcookie(Cookie_SID_Name,$this->session->getAttribute('id'),Cookie_SID_Time);
	}

}

class AAA {

	private $thesource, $classdoc, $datasource;
	public $ok, $user, $session;

	function __construct(){
		$this->thesource=new DOMImplementation;
		$this->classdoc=$this->thesource->createDocument();
		$source=explode('://',AAA_Config);
		if($source[0]=='file')
			$this->datasource=new StoreXML($source[1]);
		if(isset($_COOKIE[Cookie_ID_Name])&&isset($_COOKIE[Cookie_SID_Name]))
			if($this->user=$this->loadUser($_COOKIE[Cookie_ID_Name]))
				$this->continueSession($_COOKIE[Cookie_SID_Name]);
	}

	function pushSync(){
		if($this->user)
			if($user_chunk=$this->user->getSynced())
				$this->datasource->saveUser($user_chunk);
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

	private function authenticateUser($username,$password){
		if($user=$this->datasource->loadUser('uid'.hash('md5',$username)))
			if(0==strcasecmp($username,$user->getAttribute('username'))&&(0==strcmp('sha512;'.hash('sha512',$password),$user->getAttribute('password'))))
				return $user;
		return false;
	}

// private function deauthenticateUser($user){
	// if($user->getAttribute('logged')==1){
		// $user->setAttribute('last_logout',time());
		// $sessions=$this->loadSessions($user->getAttribute('id'));
		// if(!$test=$sessions->hasChildNodes()){
			// $user->setAttribute('logged',0);
			// return true;
		// }	
	// }
	// return false;
// }

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
	return $this->datasource->loadElement($userid,$sid);
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
		$user = $this->createUser($userdata);
		$this->datasource->saveUser($user);
		return true;
	}
	return false;
}

function dropUser($username){
	return $this->datasource->removeUser('uid'.hash('md5',$username));
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
		if($this->user = new User($this->authenticateUser($username,$password)))
			if($this->user->activeSessions()<Default_Session_Max_Count){
				$this->user->logIn(Default_Session_Livetime);
				echo "login in<br>\n";
				return true;
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
