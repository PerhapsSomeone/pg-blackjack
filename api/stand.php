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

require_once "db.php";
require_once "cards.php";
require_once "ai.php";
require "victorychecker.php";

if(match::checkWin()) {
    $currentcards = db::getCards($_GET["gameid"]);
    $currentcards["WINSTATUS"][] = "true";
    echo json_encode($currentcards, true);
} else {
    $currentcards = db::getCards($_GET["gameid"]);
    $currentcards["WINSTATUS"][] = "false";
    echo json_encode($currentcards, true);
}