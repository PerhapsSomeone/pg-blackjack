<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.08.18
 * Time: 17:09
 */

if(!isset($_GET["gameid"])) {
    header("HTTP/1.1 400 Bad Request");
    die("No GameID specified.");
}

const SPADES = ["S2", "S3", "S4", "S5", "S6", "S7", "S8", "S9", "S10", "SK", "SJ", "SQ", "SA"];
const HEARTS = ["H2", "H3", "H4", "H5", "H6", "H7", "H8", "H9", "H10", "HK", "HJ", "HQ", "HA"];
const DIAMONDS = ["D2", "D3", "D4", "D5", "D6", "D7", "D8", "D9", "D10", "DK", "DJ", "DQ", "DA"];
const CLUBS = ["C2", "C3", "C4", "C5", "C6", "C7", "C8", "C9", "C10", "CK", "CJ", "CQ", "CA"];

const KEYMAP = ["SPADES", "HEARTS", "DIAMONDS", "CLUBS"];

const CVALUES = ["1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "K" => 10, "J" => 10, "Q" => 10, "A" => 11];

function updateCards() {
    $JSON = json_encode(array(
        "SPADES" => SPADES,
        "HEARTS" => HEARTS,
        "DIAMONDS" => DIAMONDS,
        "CLUBS" => CLUBS
    ));

    return $JSON;
}

function drawCard($cards, $receiver){

    $rand1 = rand(0, sizeof($cards) - 3);

    $rand2 = rand(0, sizeof($cards[KEYMAP[$rand1]]) - 1);

    $card = $cards[KEYMAP[$rand1]][$rand2];

    array_splice($cards[KEYMAP[$rand1]], array_search($card, $cards[KEYMAP[$rand1]], true), 1);

    array_push($cards[$receiver], $card);

    $assoccards = array(
        "SPADES" => $cards["SPADES"],
        "HEARTS" => $cards["HEARTS"],
        "DIAMONDS" => $cards["DIAMONDS"],
        "CLUBS" => $cards["CLUBS"],
        "DEALERCARDS" => $cards["DEALERCARDS"],
        "PLAYERCARDS" => $cards["PLAYERCARDS"]
    );


    return array($card, $assoccards);
}