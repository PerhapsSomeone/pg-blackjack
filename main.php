<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.08.18
 * Time: 16:35
 */

?>

<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css" integrity="sha256-zIG416V1ynj3Wgju/scU80KAEWOsO5rRLfVyRDuOv7Q=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<div class="tile is-ancestor">
    <div class="tile is-parent">
        <article class="tile is-child notification is-success">
            <div class="content">
                <p class="title">Blackjack<button class="button expandButton" onclick="toggleRules()">Expand</button></p>
                <p class="subtitle">Basic Rules</p>
                <div id="rules" class="content hidden">
                    The goal of blackjack is to get as close to 21 as possible.<br />
                    Whoever is closer wins the round.<br />
                    <br />
                    After receiving an initial two cards, the player has two standard options: "hit", "stand" or "surrender".<br />
                    <br />
                    Hit: Take another card from the dealer.<br />
                    <br />
                    Stand: Take no more cards, also known as "stick", or "stay".<br />
                    <br />
                </div>
            </div>
        </article>
    </div>
</div>


<div class="tile is-ancestor">
    <div class="tile is-vertical">
        <div class="tile is-parent">
            <article class="tile is-child notification is-danger">
                <p class="title">Dealer's Hand</p>
                <p id="dealercount" class="subtitle">Please wait...</p>
                <div class="content">
                    <div id="dealerhand">

                    </div>
                </div>
            </article>
        </div>
    </div>
    <div class="tile is-parent">
        <article class="tile is-child notification is-success">
            <div class="content">
                <p class="title">Your hand</p>
                <p id="playercount" class="subtitle">Please wait...</p>
                <div class="content">
                    <div id="playerhand">

                    </div>
                    <div class="center">
                        <button class="button is-rounded" id="standbutton" onclick="hit()">Hit</button>
                        <button class="button is-rounded" id="hitbutton" onclick="standWinChecker()">Stand</button>
                        <br />
                        <button class="button is-rounded hidden" id="newgamebutton" onclick="newgame()">New Game</button>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/cookiecheck.js"></script>
<script src="js/match.js"></script>
</body>
</html>
