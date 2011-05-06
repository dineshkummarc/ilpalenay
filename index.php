<?php

function __autoload($nombreclase) {
	if(file_exists('clases/'.$nombreclase.'.class.php'))
		require_once 'clases/'.$nombreclase.'.class.php';
	elseif(false!=strpos($nombreclase,'_'))
		if(file_exists('modules/'.strtolower(substr($nombreclase,1,strpos($nombreclase,'_')-1)).'/T'.substr($nombreclase,strpos($nombreclase,'_')+1,strlen($nombreclase)).'.class.php'))
			require_once 'modules/'.strtolower(substr($nombreclase,1,strpos($nombreclase,'_')-1)).'/T'.substr($nombreclase,strpos($nombreclase,'_')+1,strlen($nombreclase)).'.class.php';
}

include 'algoritmo.php';


