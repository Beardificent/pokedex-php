<?php

//declare(strict_types=1);
//DISPLAY ERROR HANDLING

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

$pokemon = $_POST['id'];

if ($pokemon === null) {
    $pokemon = 1;
}

$getPokemon = file_get_contents('https://pokeapi.co/api/v2/pokemon/'. $pokemon);
$data = (json_decode($getPokemon, 1));


if ($data['id'] < 10) {
  $pokeId =  "#00" . $data['id'];

} else if ($data['id'] < 100) {
  $pokeId =  "#0" . $data['id'];
} else {
   $pokeId = "#" . $data['id'];
}

$getEvolutions = file_get_contents('https://pokeapi.co/api/v2/evolution-chain/'. $pokemon);
$dataEvo = (json_decode($getEvolutions, 1));


//echo "\n".$data['abilities'][1]['ability']['name'];
/*

function fourMoves ($data) {
    $moves = ();
    $maxMoves = count($data['moves']);
    echo rand($maxMoves, $minMoves);
}


*/




?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" >
    <title>Dex PHP</title>
</head>
<body>

<form action="index.php" method="post">
Name or Id: <input type="text" name="id">
<input type="submit">
</form>

<img src="<?php echo $data['sprites']['front_default'];?>" alt="frontPoke">
<img src="<?php echo $data['sprites']['back_default'];?>" alt="backPoke">
<div id="pokeName" class="pokeName">Name: <?php echo $data['name'];?></div>
<div id="pokeId" class="pokeId"><?php echo $pokeId;?></div>


<div id="pokeAbility" class="pokeAbility">Special Ability: <?php echo $data['abilities'][0]['ability']['name'];?></div>

<div class="pokeMoveSet">
    <div id="move-one" class="move-one"><?php echo $data['moves'][0]['move']['name'];?></div>
    <div id="move-two" class="move-two"><?php echo $data['moves'][1]['move']['name'];?></div>
    <div id="move-three" class="move-three"><?php echo $data['moves'][2]['move']['name'];?></div>
    <div id="move-four" class="move-four"> <?php echo $data['moves'][3]['move']['name'];?></div>
</div>

<div id="evolutionChain" class="evolutionChain">
<!--<img src="?php echo $dataEvo['sprites']['front_default'];?"</div>-->
</body>
</html>
