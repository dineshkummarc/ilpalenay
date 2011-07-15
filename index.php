<?php

require_once 'defaults.php';
require_once 'config.php';

// require_once 'datasource.php';
require_once 'aaa.php';
// require_once 'data.php';
require_once 'composer.php';
// require_once 'filetree.php';

function __autoload($nombreclase) {
	$path='modules/'.strtolower(substr($nombreclase,1,strpos($nombreclase,'_')-1)).'/T'.substr($nombreclase,strpos($nombreclase,'_')+1,strlen($nombreclase)).'.class.php';
	if(file_exists($path))
		require_once $path;
}

// $ftree=new FileTree();
// $ftree->checkFreshInstall();

$auth=new AAA();
// $data=new Data();
$composer=new Composer();

// $oqdata=new TOpenQst_Data();

if(isset($_POST['logout']))
	$auth->logOut();

if(isset($_POST['username'])&&isset($_POST['password']))
	$auth->logIn($_POST['username'],$_POST['password']);

if(isset($auth->user->tagName)){
	if($auth->session->tagName){
		$composer->enableBlock('ilpalenay_logOutBox',false);
		$composer->enableBlock('openqst_prueba',$oqdata->data);
	}
	else
		$composer->enableBlock('ilpalenay_authenticationBox',false);
}
else
	$composer->enableBlock('ilpalenay_authenticationBox',false);
		
// $users1=array('type'=>'xmlfile','id'=>'users1','path'=>'datasource/users1.xml');
// $auth->addSource($users1);
// $auth->purgeSource('users1');
$irving=array('username'=>'irving','password'=>'123456');
// $auth->addUser($irving);
// $auth->dropUser($irving['username']);
// $auth->logOut();
// var_dump($auth);
$composer->sendXML();
