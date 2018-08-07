<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.08.18
 * Time: 17:19
 */

if(!isset($_GET["gameid"])) {
    header("HTTP/1.1 400 Bad Request");
    die("No GameID specified.");
}


class ai {
    public static function decideAction($uuid, $currentcards) {
        $CVALUES = ["1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "K" => 10, "J" => 10, "Q" => 10, "A" => 11];
        //print_r($currentcards);

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


        if($dealervalue < 12) {
            $currentcards = drawCard($currentcards, "DEALERCARDS")[1];
        }

        db::updateCards($uuid, json_encode($currentcards));
    }
}