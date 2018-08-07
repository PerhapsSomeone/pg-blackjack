const SPADES = ["S2", "S3", "S4", "S5", "S6", "S7", "S8", "S9", "S10", "SK", "SJ", "SQ", "SA"];
const HEARTS = ["H2", "H3", "H4", "H5", "H6", "H7", "H8", "H9", "H10", "HK", "HJ", "HQ", "HA"];
const DIAMONDS = ["D2", "D3", "D4", "D5", "D6", "D7", "D8", "D9", "D10", "DK", "DJ", "DQ", "DA"];
const CLUBS = ["C2", "C3", "C4", "C5", "C6", "C7", "C8", "C9", "C10", "CK", "CJ", "CQ", "CA"];

const CVALUES = {"1": 1, "2": 2, "3": 3, "4": 4, "5": 5, "6": 6, "7": 7, "8": 8, "9": 9, "10": 10, "K": 10, "J": 10, "Q": 10, "A": 11};

const CARDS = {
    "S2": "2_of_clubs.png",
    "S3": "3_of_clubs.png",
    "S4": "4_of_clubs.png",
    "S5": "5_of_clubs.png",
    "S6": "6_of_clubs.png",
    "S7": "7_of_clubs.png",
    "S8": "8_of_clubs.png",
    "S9": "9_of_clubs.png",
    "S10": "10_of_clubs.png",
    "SK": "king_of_clubs.png",
    "SJ": "jack_of_clubs.png",
    "SQ": "queen_of_clubs.png",
    "SA": "ace_of_clubs.png",

    "H2": "2_of_hearts.png",
    "H3": "3_of_hearts.png",
    "H4": "4_of_hearts.png",
    "H5": "5_of_hearts.png",
    "H6": "6_of_hearts.png",
    "H7": "7_of_hearts.png",
    "H8": "8_of_hearts.png",
    "H9": "9_of_hearts.png",
    "H10": "10_of_hearts.png",
    "HK": "king_of_hearts.png",
    "HJ": "jack_of_hearts.png",
    "HQ": "queen_of_hearts.png",
    "HA": "ace_of_hearts.png",

    "D2": "2_of_diamonds.png",
    "D3": "3_of_diamonds.png",
    "D4": "4_of_diamonds.png",
    "D5": "5_of_diamonds.png",
    "D6": "6_of_diamonds.png",
    "D7": "7_of_diamonds.png",
    "D8": "8_of_diamonds.png",
    "D9": "9_of_diamonds.png",
    "D10": "10_of_diamonds.png",
    "DK": "king_of_diamonds.png",
    "DJ": "jack_of_diamonds.png",
    "DQ": "queen_of_diamonds.png",
    "DA": "ace_of_diamonds.png",

    "C2": "2_of_clubs.png",
    "C3": "3_of_clubs.png",
    "C4": "4_of_clubs.png",
    "C5": "5_of_clubs.png",
    "C6": "6_of_clubs.png",
    "C7": "7_of_clubs.png",
    "C8": "8_of_clubs.png",
    "C9": "9_of_clubs.png",
    "C10": "10_of_clubs.png",
    "CK": "king_of_clubs.png",
    "CJ": "jack_of_clubs.png",
    "CQ": "queen_of_clubs.png",
    "CA": "ace_of_clubs.png"
};

let CARDRESPONSE;

let playerCards = [];
let dealerCards = [];

let dealerValue = 0;
let playerValue = 0;

let playerCardImages = "";
let dealerCardImages = "";

let cards;
let matchid = getCookie("matchid");

let standWinCheck = false;

function toggleRules() {
    let ruleDiv = document.getElementById("rules");

    if(ruleDiv.className === "content hidden") {
        ruleDiv.className = "content";
    } else {
        ruleDiv.className = "content hidden";
    }
}

function initialCards() {
    fetch("api/startmatch.php?gameid=" + matchid)
        .then((res) => {
            return res.text();
        })
        .then(((data => {
            CARDRESPONSE = data;
            updateCards(JSON.parse(data));
        })));
}

function hit() {
    fetch("api/draw.php?gameid=" + matchid)
        .then((res) => {
            return res.text();
        })
        .then(((data => {
            CARDRESPONSE = data;
            updateCards(JSON.parse(data));
        })));
}

function stand() {
    fetch("api/stand.php?gameid=" + matchid)
        .then((res) => {
            return res.text();
        })
        .then(((data => {
            CARDRESPONSE = data;
            updateCards(JSON.parse(data));
        })));
}


function standWinChecker() {
    standWinCheck = true;

    stand();
}

function updateCards(json) {
    playerCards = json["PLAYERCARDS"];
    dealerCards = json["DEALERCARDS"];
    dealerValue = 0;
    playerValue = 0;
    playerCardImages = "";

    playerCards.forEach(function (card) {
        playerValue += CVALUES[card.substring(1)];
        playerCardImages += "<img src='cards/" + CARDS[card] + "'></img>";
    });

    document.getElementById("playerhand").innerHTML = playerCardImages;


    dealerCardImages = "";

    dealerCards.forEach(function (card) {
        dealerValue += CVALUES[card.substring(1)];
        dealerCardImages += "<img src='cards/" + CARDS[card] + "'></img>";
    });

    document.getElementById("dealerhand").innerHTML = dealerCardImages;

    document.getElementById("playercount").innerHTML = "Value: " + playerValue;
    document.getElementById("dealercount").innerHTML = "Value: " + dealerValue;


    if(playerValue > 21) {
        fetch("api/stand.php?gameid=" + matchid);
        swal("You lost!", "You surpassed 21.", "error");

        document.getElementById("standbutton").disabled = true;
        document.getElementById("hitbutton").disabled = true;
        document.getElementById("newgamebutton").className = "button is-rounded";
    }

    if(standWinCheck) {
        if(dealerValue > 21) {
            swal("You won!", "The dealer surpassed 21.", "success");
            document.getElementById("standbutton").disabled = true;
            document.getElementById("hitbutton").disabled = true;
            document.getElementById("newgamebutton").className = "button is-rounded";
        } else if(dealerValue > playerValue) {
            swal("You lost!", "The dealer's value beat yours.", "error");
            document.getElementById("standbutton").disabled = true;
            document.getElementById("hitbutton").disabled = true;
            document.getElementById("newgamebutton").className = "button is-rounded";
        } else if(playerValue > dealerValue) {
            swal("You won!", "You beat the dealer's value.", "success");
            document.getElementById("standbutton").disabled = true;
            document.getElementById("hitbutton").disabled = true;
            document.getElementById("newgamebutton").className = "button is-rounded";
        }
    }
}

function newgame() {
    eraseCookie("matchid");
    setCookie("matchid", uuidv4(), 1);
    window.location.reload();
}

initialCards();