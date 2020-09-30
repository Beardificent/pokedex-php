<?php

declare(strict_types=0);
//DISPLAY ERROR HANDLING

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

/*
// a new dom object
$dom = new DOMDocument();

// load the html into the object
$dom->loadHTML('filename.html');

// discard white space
$dom->preserveWhiteSpace = false;
*/

$pokemon = $_POST['id'];


if ($pokemon === null) {
    $pokemon = 1;
}

//FETCH POKE API

$getPokemon = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon);
$data = (json_decode($getPokemon, true));
$pokeTypeOne = $data['types'][0]['type']['name'];
$pokeTypeTwo = $data['types'][1]['type']['name'];

//IF STATEMENT TO REPLACE PADSTART(0, 3)
if ($data['id'] < 10) {
    $pokeId = "#00" . $data['id'];

} else if ($data['id'] < 100) {
    $pokeId = "#0" . $data['id'];
} else {
    $pokeId = "#" . $data['id'];
}

//Fetch for species
$getSpecies = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $pokemon);
$dataSpecies = (json_decode($getSpecies, True));
$flavorText = $dataSpecies['flavor_text_entries'][0]['flavor_text'];

//works for bulbasaur (displays next evolution names) but bricks as soon as ivysaur
$getEvolutions = file_get_contents('https://pokeapi.co/api/v2/evolution-chain/' . $pokemon);
$dataEvo = (json_decode($getEvolutions, True));
$evoChainOne = $dataEvo['chain']['evolves_to'][0]['species']['name'];
$evoChainTwo = $dataEvo['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'];

//Random moves generator (max 4) no idea how to print this value as a single to body. appendchild maybe?

$moves = array();
$maxMoves = count($data['moves']);
for ($i = 0; $i < 4; $i++) {
    $rand = floor(rand(0, $maxMoves));
    array_push($moves, $data['moves'][$rand]['move']['name']);
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Dex PHP</title>
</head>
<body>

<form action="index.php" method="post">
    Name or Id: <input type="text" name="id">
    <input type="submit">
</form>
<div class="pokeInfo">
    <img src="<?php echo $data['sprites']['front_default']; ?>" alt="frontPoke">
    <img src="<?php echo $data['sprites']['back_default']; ?>" alt="backPoke">
    <div id="pokeId" class="pokeId"><?php echo $pokeId; ?></div>

    <div id="pokeName" class="pokeName">Name: <?php echo $data['species']['name']; ?></div>

    <div class="pokeType-wrapper">
        <div id="type-one" class="pokeType"><?php echo $pokeTypeOne; ?></div>
        <div id="type-two" class="pokeType"><?php echo $pokeTypeTwo; ?></div>
    </div>

    <div id="descrip" class="flavortext"><?php echo $flavorText; ?></div>

    <div id="pokeAbility" class="pokeAbility">Special
        Ability: <?php echo $data['abilities'][0]['ability']['name']; ?></div>

    <div class="pokeMove-wrapper">
        <div id="move-one" class="moves"><?php echo $moves[0] ?></div>
        <div id="move-two" class="moves"><?php echo $moves[1]; ?></div>
        <div id="move-three" class="moves"><?php echo $moves[2]; ?></div>
        <div id="move-four" class="moves"> <?php echo $moves[3]; ?></div>
    </div>

    <div class="evolutionChain">
        <?php echo $evoChainOne;?><br/>
        <?php echo $evoChainTwo;?>
    </div>
</body>
</html>

