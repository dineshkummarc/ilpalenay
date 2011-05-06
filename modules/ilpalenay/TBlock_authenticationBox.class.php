<?php

class Tilpalenay_Block_authenticationBox {

function build($data){
	$thesource=new DOMImplementation;
	$document=$thesource->createDocument();
	$block=$document->createElement('div');
	$block->setAttribute('id','authenticationBox');
	$form=$document->createElement('form');
	$block->appendChild($form);
	$form->setAttribute('method','post');
	$form->setAttribute('action','#');
	$namelabel=$document->createElement('label');
	$form->appendChild($namelabel);
	$namelabel->setAttribute('for','nameinput');
	$namelabel->appendChild($document->createTextNode('Nombre:'));
	$nameinput=$document->createElement('input');
	$form->appendChild($nameinput);
	$nameinput->setAttribute('id','nameinput');
	$nameinput->setAttribute('type','text');
	$nameinput->setAttribute('name','username');
	$passwordlabel=$document->createElement('label');
	$form->appendChild($passwordlabel);
	$passwordlabel->setAttribute('for','passwordinput');
	$passwordlabel->appendChild($document->createTextNode('Contrseña:'));
	$passwordinput=$document->createElement('input');
	$form->appendChild($passwordinput);
	$passwordinput->setAttribute('id','passwordinput');
	$passwordinput->setAttribute('type','password');
	$passwordinput->setAttribute('name','password');
	$authbutton=$document->createElement('button');
	$form->appendChild($authbutton);
	$authbutton->setAttribute('type','submit');
	$authbutton->appendChild($document->createTextNode('Autenticar'));
	return $block;
}

}
