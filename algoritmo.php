<?php

$ftree=new TFileTree();
$ftree->checkFreshInstall();

$auth=new TAAA();
$data=new TData();
$composer=new TComposer();
$oqdata=new TOpenQst_Data();

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
$irving=array('username'=>'irvingleonard','password'=>'123');
// $auth->addUser($irving);
// $auth->dropUser($irving['username']);
// $auth->logOut();
// var_dump($auth);
$composer->sendXML();
