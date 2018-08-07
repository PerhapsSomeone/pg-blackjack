<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 07.08.18
 * Time: 17:25
 */

if(!isset($_GET["gameid"])) {
    header("HTTP/1.1 400 Bad Request");
    die("No GameID specified.");
}

require_once "db.php";
require_once "cards.php";
require_once "ai.php";

class match {
    public static function checkWin() {
        $CVALUES = json_decode('{"1": 1, "2": 2, "3": 3, "4": 4, "5": 5, "6": 6, "7": 7, "8": 8, "9": 9, "10": 10, "K": 10, "J": 10, "Q": 10, "A": 11}', true);

        $currentcards = db::getCards($_GET["gameid"]);

        $dealervalue = 0;
        $dealercards = $currentcards["DEALERCARDS"];

        foreach ($dealercards as $card) {
            $dealervalue += $CVALUES[substr($card, -1)];
        }

        if($dealervalue <= 16) {
            $currentcards = drawCard($currentcards, "DEALERCARDS")[1];
        }

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

        $playerWon = false;

        if($playervalue > 21) {
            $playerWon = false;
        }

        if($playervalue === $dealervalue) {
            $playerWon = false;
        }

        if($dealervalue > $playervalue) {
            $playerWon = false;
        }

        if($playervalue > $dealervalue) {
            $playerWon = true;
        }

        db::updateCards($_GET["gameid"], json_encode($currentcards));
        db::endMatch($_GET["gameid"]);

        return $playerWon;
    }
}

