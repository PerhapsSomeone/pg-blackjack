<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.08.18
 * Time: 17:26
 */

if(!isset($_GET["gameid"]) || strlen($_GET["gameid"]) !== 36) {
    header("HTTP/1.1 400 Bad Request");
    die("No GameID specified.");
}

require_once "cards.php";
require_once "db.php";

if(db::checkMatchExists($_GET["gameid"])) {
    die(json_encode(db::getCards($_GET["gameid"])));
}

try {
    // First Dealer Card

    $cards = array(SPADES, HEARTS, DIAMONDS, CLUBS);

    $rand1 = random_int(0, sizeof($cards) - 1);
    $rand2 = random_int(0, sizeof($cards[$rand1]) - 1);

    $dealer1 = $cards[$rand1][$rand2];

    array_splice($cards[$rand1], $rand2, 1);

    // First Player Card

    $cards = array(SPADES, HEARTS, DIAMONDS, CLUBS);

    $rand1 = random_int(0, sizeof($cards) - 1);
    $rand2 = random_int(0, sizeof($cards[$rand1]) - 1);

    $player1 = $cards[$rand1][$rand2];

    array_splice($cards[$rand1], $rand2, 1);

    // Second Player Card

    $cards = array(SPADES, HEARTS, DIAMONDS, CLUBS);

    $rand1 = random_int(0, sizeof($cards) - 1);
    $rand2 = random_int(0, sizeof($cards[$rand1]) - 1);

    $player2 = $cards[$rand1][$rand2];

    array_splice($cards[$rand1], $rand2, 1);


    $assoccards = array(
        "SPADES" => $cards[0],
        "HEARTS" => $cards[1],
        "DIAMONDS" => $cards[2],
        "CLUBS" => $cards[3],
        "DEALERCARDS" => [$dealer1],
        "PLAYERCARDS" => [$player1, $player2]
    );

    db::initalInsert($_GET["gameid"], json_encode($assoccards));

    echo json_encode($assoccards);
} catch (Exception $exception) {
    echo $exception;
}