<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.08.18
 * Time: 16:16
 */



?>

<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css" integrity="sha256-zIG416V1ynj3Wgju/scU80KAEWOsO5rRLfVyRDuOv7Q=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>

<section class="hero is-success">
    <div class="hero-body">
        <div class="container">
            <h1 class="header">PG Blackjack</h1>
        </div>
    </div>
</section>


<div class="container">
    <div class="notification">
        Blackjack, also known as twenty-one, is a comparing card game between usually a player and a dealer, where player against the dealer, but they do not play against each other. It is played with one or more decks of 52 cards, and is the most widely played casino banking game in the world.<br />The objective of the game is to beat the dealer in one of the following ways:
        <br />
        Get 21 points on the player's first two cards (called a "blackjack" or "natural"), without a dealer blackjack;<br />
        Reach a final score higher than the dealer without exceeding 21; or<br />
        Let the dealer draw additional cards until their hand exceeds 21.<br />
    </div>
</div>

<div class="startbutton container">
    <div class="notification">
        <button class="button startbutton is-outlined is-success" onclick="startGame()">Start the game</button>
    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/cookiecheck.js"></script>
<script>
    if(!checkCookie()) {
        swal("Error!", "You currently have cookies disabled.\nThis means you won't be able to play the game.\nPlease enable them.", "error");
    } else {
        setCookie("matchid", uuidv4(), 1);
    }
</script>
</body>
</html>