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

$pokemon = "";

if (isset ($_POST['id'])){
    $pokemon = $_POST['id'];
}else {
    $pokemon = 4;
}

//FETCH POKE API

$getPokemon = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon);
$data = (json_decode($getPokemon, True));
$pokeTypesArr = array ();
$pokeTypeOne = $data['types'][0]['type']['name'];
$pokeTypeTwo = " ";
if(isset($data['types'][1]['type']['name'])){
    $pokeTypeTwo = $data['types'][1]['type']['name'];
} else {
    $pokeTypeTwo = " ";
}
$pokeColorOne = getColor($data['types'][0]['type']['name']);
$pokeColorTwo = "";
if (isset($data['types'][1]['type']['name'])){
    $pokeColorTwo = getColor($data['types'][1]['type']['name']);
} else {
    $pokeColorTwo = $pokeColorOne;
}


function getColor($type)
{
    $color = "";
    switch ($type) {
        case "normal":
            $color = "rgb(186, 186, 174)";
            break;
        case "fighting":
            $color = "rgb(167, 85, 67)";
            break;
        case "flying":
            $color = "rgb(120, 162, 215)";
            break;
        case "poison":
            $color = "rgb(169, 92, 160)";
            break;
        case "ground":
            $color = "rgb(238, 204, 85)";
            break;
        case "rock":
            $color = "rgb(204, 189, 114)";
            break;
        case "bug":
            $color = "rgb(194, 210,30)";
            break;
        case "ghost":
            $color = "rgb(121,117,215)";
            break;
        case "steel":
            $color = "rgb(196, 194,219)";
            break;
        case "fire":
            $color = "rgb(250, 86, 67)";
            break;
        case "water":
            $color = "rgb(86, 173, 255)";
            break;
        case "grass":
            $color = "rgb(140, 215, 80)";
            break;
        case "electric":
            $color = "rgb(253, 225, 57)";
            break;
        case "psychic":
            $color = "rgb(250,101, 180)";
            break;
        case "ice":
            $color = "rgb(150, 241, 255)";
            break;
        case "dragon":
            $color = "rgb(134, 115, 255)";
            break;
        case "dark":
            $color = "rgb(141, 104, 85)";
            break;
        case "fairy":
            $color = "rgb(249, 174, 255)";
            break;

    }
    return $color;
}
//ATTEMPT TO FOR EACH THE POKETYPES
/*
foreach ($data['types'] as $type){
    array_push($pokeTypesArr, $type);
    var_dump($pokeTypesArr);
}
*/
//

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
$flavorText = $dataSpecies['flavor_text_entries'][4]['flavor_text'];


$getEvolutions = file_get_contents($dataSpecies['evolution_chain']['url']);
$dataEvo = (json_decode($getEvolutions, True));
$dataEvoCopy = $dataEvo['chain'];
$evoArr = array();

//We're pushing the data (names via species) into an array and also ordering via IF that if the array reaches EVOLVES_TO[0], to dive deeper into it until there is no EVOLVES_TO[0]
do {
    array_push($evoArr, $dataEvoCopy['species']['name']);
    if($dataEvoCopy['evolves_to']){
        $dataEvoCopy = $dataEvoCopy['evolves_to'][0];
    }else {
        $dataEvoCopy = null;
    }

} while (!!$dataEvoCopy);


//Random moves generator (max 4)
$moves = array();
$maxMoves = count($data['moves']);
for ($i = 0; $i < 4; $i++) {
    $rand = floor(rand(0, $maxMoves -1));
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
    <title>Pokedex</title>
</head>
<body>



<div class="pokedex">
    <div class="test-container">
        <div class="test-container__black">
            <div class="test-container__screen">
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <div class="list-item"></div>
                <!-- <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>
                 <div class="list-item"></div>-->
            </div>
        </div>
    </div>
    <div class="left-container">
        <div class="left-container__top-section">
            <div class="top-section__blue"></div>
            <div class="top-section__small-buttons">
                <div class="top-section__red"></div>
                <div class="top-section__yellow"></div>
                <div class="top-section__green"></div>
            </div>
        </div>

        <div class="left-container__main-section-container">

            <div class="side-container__right">
                <div class="side-container__hinge"></div>
                <div class="side-container__hinge"></div>
            </div>
            <div class="left-container__main-section">
                <div class="main-section__white" style="background-image: linear-gradient(to right, <?php echo $pokeColorOne . ', ' . $pokeColorTwo; ?>)">
                    <div class="main-section__black">
                        <div class="main-screen" >
                            <div class="screen__header" >
                                <span class="poke-name"><?php echo $data['species']['name']; ?></span>
                                <span class="poke-id"><?php echo $pokeId; ?></span>
                            </div>
                            <div class="screen__image" >
                                <img class ="pokeImg" src="<?php echo $data['sprites']['front_default']; ?>" alt="frontPoke">
                                <img class="pokeImg" src="<?php echo $data['sprites']['back_default']; ?>" alt="">
                            </div>
                            <div class="screen__description">
                                <div class="stats__types">
                                    <span class="poke-type-one"><?php echo $pokeTypeOne; ?></span>
                                    <span class="poke-type-two"><?php echo $pokeTypeTwo; ?></span>
                                </div>
                                <div class="screen__stats">
                                    <?php forEach ($moves as $pokeMove){
                                        echo "$pokeMove<br/>";
                                    }
                                    ;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="left-container__controllers">
                    <div class="controllers__d-pad">
                        <div class="d-pad__cell top "></div>
                        <button class="d-pad__cell left "></button>
                        <div class="d-pad__cell middle"></div>
                        <button class="d-pad__cell right"></button>
                        <div class="d-pad__cell bottom"></div>
                    </div>
                    <div class="controllers__buttons">
                        <button id ="bButton" name="bButton" type="submit" class="buttons__button">B</button>
                        <button id ="aButton" name="aButton" type="submit" class="buttons__button">A</button>
                    </div>
                </div>
            </div>
            <div class="left-container__right">
                <div class="left-container__hinge"></div>
                <div class="left-container__hinge"></div>
            </div>
        </div>
    </div>
    <div class="right-container">
        <div class="right-container__black">
            <div class="right-container__screen">
                <?php echo $flavorText; ?>
            </div>
            <div class="right-container__screen ">
                <?php foreach ($evoArr as $poke){
                    $getEvoSpriteUrl = file_get_contents('https://pokeapi.co/api/v2/pokemon/'.$poke);
                    $evoSpriteData = json_decode($getEvoSpriteUrl, True);
                    ?> <img width="72" height="72" src="<?php echo $evoSpriteData['sprites']['front_default'];?>"> <?php

                }
                ;?>
            </div>
        </div>
        <form action="index.php" class="input_wrapper" method="post">
            <input type="text" name="id"  class="input" placeholder="Name or ID number">
        </form>
        <div class="right-container__buttons">
            <!--   <div class="left-button">Prev</div>
               <div class="right-button">Next</div>-->
        </div>
    </div>
</div>
</body>

<!--ORIGINAL HTML BEFORE TAKING IT FROM JS DEX-->
<!--<?php /*
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
    <div class="pokeSprite-Wrapper" style="background-image: linear-gradient(to right, <?php echo $pokeColorOne . ', ' . $pokeColorTwo; ?>)">
        <div id="pokeId" class="pokeId"><?php echo $pokeId; ?></div>
        <div class="typeColor">
        <img class ="pokeImg" src="<?php echo $data['sprites']['front_default']; ?>" alt="frontPoke">
        <img class="pokeImg" src="<?php echo $data['sprites']['back_default']; ?>" alt="">
        </div>

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

<div class="evolutions" style="background-image: linear-gradient(to right, <?php echo $pokeColorOne . ', ' . $pokeColorTwo; ?>)">
    <?php foreach ($evoArr as $poke){
        $getEvoSpriteUrl = file_get_contents('https://pokeapi.co/api/v2/pokemon/'.$poke);
        $evoSpriteData = json_decode($getEvoSpriteUrl, True);
        ?> <img src="<?php echo $evoSpriteData['sprites']['front_default'];?>"> <?php

    }
    ;?>
</div>
</body>
</html>
*/;?>-->
