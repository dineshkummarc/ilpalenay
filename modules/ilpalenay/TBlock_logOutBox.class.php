<?php

class Tilpalenay_Block_logOutBox {

function build($data){
	$thesource=new DOMImplementation;
	$document=$thesource->createDocument();
	$block=$document->createElement('div');
	$block->setAttribute('id','logOutBox');
	$form=$document->createElement('form');
	$block->appendChild($form);
	$form->setAttribute('method','post');
	$form->setAttribute('action','#');
	$authbutton=$document->createElement('button');
	$form->appendChild($authbutton);
	$authbutton->setAttribute('type','submit');
	$authbutton->setAttribute('name','logout');
	$authbutton->appendChild($document->createTextNode('Salir'));
	$form->appendChild($authbutton);
	return $block;
}

}
