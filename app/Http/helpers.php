<?php

/****************************************************************************************
PRINT VARIABLE
****************************************************************************************/

function ddAll($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';

	exit();
}

function prf($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}


/****************************************************************************************
SET ACTIVE TAB
****************************************************************************************/

function setActive($path, $active = 'active') {
	return Request::is($path) ? $active : '';
}


/****************************************************************************************
GET MANA SYMBOLS
****************************************************************************************/

function getManaSymbols($manaCost) {

	$manaCost = preg_replace("/{(\d+)}/", '<i class="mi mi-mana mi-shadow mi-$1"></i>', $manaCost);

	$manaCost = preg_replace("/{(\D)}/", '<i class="mi mi-mana mi-shadow mi-$1"></i>', $manaCost);
	$manaCost = strtolower($manaCost);

	return $manaCost;
}
