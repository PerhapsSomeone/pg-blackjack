<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.08.18
 * Time: 16:50
 */

if(!isset($_GET["gameid"])) {
    header("HTTP/1.1 400 Bad Request");
    die("No GameID specified.");
}

$CVALUES = ["1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "K" => 10, "J" => 10, "Q" => 10, "A" => 11];

require_once "db.php";
require_once "cards.php";
require_once "ai.php";

$currentcards = db::getCards($_GET["gameid"]);

$currentcards = drawCard($currentcards, "PLAYERCARDS")[1];

$dealercards = $currentcards["DEALERCARDS"];
$playercards = $currentcards["PLAYERCARDS"];

$playervalue = 0;
$dealervalue = 0;

foreach ($playercards as $card) {
    if(strlen($card) === 3) {
        $playervalue += 10;
    } else {
        $playervalue += $CVALUES[substr($card, -1)];
    }
}

foreach ($dealercards as $card) {
    if(strlen($card) === 3) {
        $dealervalue += 10;
    }
    else {
        $dealervalue += $CVALUES[substr($card, -1)];
    }
}

db::updateCards($_GET["gameid"], json_encode($currentcards));

ai::decideAction($_GET["gameid"], $currentcards);

if($playervalue > 21) {
    $currentcards = db::getCards($_GET["gameid"]);
    $currentcards["WINSTATUS"][] = "false";
    echo json_encode($currentcards, true);
} else {
    echo json_encode($currentcards, true);
}