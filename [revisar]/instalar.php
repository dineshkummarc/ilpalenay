<?php

include 'utilexpl.php';

function __autoload($nombreclase) {
 require_once 'clases/'.$nombreclase.'.php';
}

$core = new TCore();
$core->actualizarmod(); 

echo "\n";