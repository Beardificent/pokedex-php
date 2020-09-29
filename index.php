<?php

//declare(strict_types=1);
//DISPLAY ERROR HANDLING

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

/*
if (empty($_GET['pokemon'])){
    $formData = file_get_contents();
    $formDataSpecies = file_get_contents('https://pokeapi.co/api/v2/type/10/');
} else {
    $formData = file_get_contents('https://pokeapi.co/api/v2/pokemon');
    $formDataSpecies = file_get_contents('https://pokeapi.co/api/v2/type');
}
$base = 'https://pokeapi.co/api/v2/pokemon';
$input = '';
*/

$jsonobj = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $_GET['id']);
var_dump(json_decode($jsonobj));
echo $jsonobj;

