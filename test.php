<?php

class testit extends DOMElement{

public $esto;

function candela(){
	echo 'esto es candela';
}

} 


$test=new testit('test');
$test->setAttribute('algo','paso');
var_dump($test);