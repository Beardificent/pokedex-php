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
$data = (json_decode($getPokemon, True));
$pokeTypeOne = $data['types'][0]['type']['name'];
//$pokeTypeTwo = $data['types'][1]['type']['name'];

//Attempt to hide typeTwo in case there is none
/*
if ($data['types'][1]['type']['name'] === 0){
    $pokeTypeTwo = " ";
}else {
    $pokeTypeTwo = $data['types'][1]['type']['name'];
}
*/

//IF STATEMENT TO REPLACE PADSTART(0, 3) for ID NUMBER
if ($data['id'] < 10) {
    $pokeId = "#00" . $data['id'];

} else if ($data['id'] < 100) {
    $pokeId = "#0" . $data['id'];
} else {
    $pokeId = "#" . $data['id'];
}

//Fetch for Flavor text
$getSpecies = file_get_contents($data['species']['url']);
$dataSpecies = (json_decode($getSpecies, True));
$flavorText = $dataSpecies['flavor_text_entries'][3]['flavor_text'];

//works for bulbasaur (displays next evolution names) but bricks as soon as ivysaur
$getEvolutions = file_get_contents($dataSpecies['evolution_chain']['url']);
$dataEvo = (json_decode($getEvolutions, True));
$dataEvoCopy = $dataEvo['chain'];
$evoArr = array();

//DOWHILE push evolution data into array while there is an array to add. if not it stops looking. Xander helped me with this one! will look up later!
do {
    array_push($evoArr, $dataEvoCopy['species']['name']);
    if($dataEvoCopy['evolves_to']){
        $dataEvoCopy = $dataEvoCopy['evolves_to'][0];
    }else {
        $dataEvoCopy = null;
    }

} while (!!$dataEvoCopy);
//THIS IS A HARDCODE FIX AND IT DOESNT FIX ANYTHING WHEN YOU THINK ABOUT IT - ECHOED IN HTML BELOW

/*
if (!$prevEvo || !$nextEvo){
    $prevEvo = " ";
    $nextEvo = " ";
}
*/
/*
for ($i = 0; $i < count($evoArr); $i++) {
    echo $evoArr[$i]['species']['name'];
}

$evoChainOne = $dataEvo['chain']['evolves_to'][0]['species']['name'];
$evoChainTwo = $dataEvo['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'];
*/



//Random moves generator (max 4)
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
    <input type="text" name="id" placeholder="Name or ID number">
    <input type="submit">
</form>

<div class="pokeInfo">
    <div class="pokeSprite-Wrapper">
        <div id="pokeId" class="pokeId"><?php echo $pokeId; ?></div>
        <img src="<?php echo $data['sprites']['front_default']; ?>" alt="frontPoke">
        <img src="<?php echo $data['sprites']['back_default']; ?>" alt="backPoke">

    </div>
    <div id="descrip" class="flavortext">Description: <br/><?php echo $flavorText; ?></div>

    <div id="pokeName" class="pokeName">Name: <?php echo $data['species']['name']; ?></div>

    <div class="pokeType-wrapper">
        <div id="pokeType" class="type-one"><?php echo $pokeTypeOne; ?></div>
        <div id="pokeType" class="type-two"><?php// echo $pokeTypeTwo; ?></div>
    </div>


    <div id="pokeAbility" class="pokeAbility-wrapper">Special
        Ability: <?php echo $data['abilities'][0]['ability']['name']; ?></div>

    <div class="pokeMove-wrapper">
        <?php forEach ($moves as $pokeMove){
            echo "$pokeMove<br/>";
        }
        ;?>
    </div>

<div class="evolutions">
    <?php foreach ($evoArr as $poke){
        $getEvoSpriteUrl = file_get_contents('https://pokeapi.co/api/v2/pokemon/'.$poke);
        $evoSpriteData = json_decode($getEvoSpriteUrl, True);
        ?> <img src="<?php echo $evoSpriteData['sprites']['front_default'];?>"> <?php

    }
    ;?>
</div>
</body>
</html>
