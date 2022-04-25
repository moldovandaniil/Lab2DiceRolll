<?php

$mysqli = new mysqli("localhost", "root", "", "diceRoll_db");

$stmt = $mysqli->prepare("SELECT * FROM games");
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$numberOfRows = 0;
foreach ($result as $row) {
    $numberOfRows = $row['numberOfRolls'];
    $playerOne = $row['first_player'];
    $playerTwo = $row['second_player'];
}

function btnClick(){
    return ?> <div>AAAAAAAAAAAAAAAAA</div>
    <?php
}

?>
<link rel = "stylesheet" type="text/css" href="play_page_style.css"
    <head>
        <title>DiceRoll Game!</title>
    </head>

    <body>
        <div class="container-top">
            <div id="rolls-count-text" class="rolls-count-text"><span id="player-name" class="player-name"><?php echo $playerOne;?></span> Rolls the dice!</div>
            <div id="spins-left-for-fP" class="spins-left-for-fP"><?php echo $playerOne;?> : <span id="fPPoints">0</span> Points ; <span id="spinsFP"><?php echo $numberOfRows;?></span> Rolls Left!</div>
            <div id="spins-left-for-sP" class="spins-left-for-sP"><?php echo $playerTwo;?> : <span id="sPPoints">0</span> Points ; <span id="spinsSP"><?php echo $numberOfRows;?></span> Rolls Left!</div>
            <div id="button-holder">
                <input type="button" id="roll-the-dice" class="roll-the-dice" value="Roll the Dice" onclick="btnClick()" </input>

            </div>
            <input type="button" id="roll-the-dice" class="roll-the-dice2" value="Check the Leaderboard" onclick="seeLeaders()" </input>
            <script>
                function btnClick(){
                    var fPNumberOfRows = parseInt(document.getElementById("spinsFP").innerText);
                    var sPNumberOfRows = parseInt(document.getElementById("spinsSP").innerText);
                    console.log(fPNumberOfRows);
                    console.log(sPNumberOfRows);
                    var fP = "<?php echo $playerOne;?>";
                    var sP = "<?php echo $playerTwo;?>";
                    if(sPNumberOfRows == 0){
                        document.getElementById("player-name").innerHTML = "";
                        if(parseInt(document.getElementById("fPPoints").innerText) ==  parseInt(document.getElementById("sPPoints").innerText)){
                            document.getElementById("rolls-count-text").innerText = "DRAW!";
                        }
                        if(parseInt(document.getElementById("fPPoints").innerText) > parseInt(document.getElementById("sPPoints").innerText)){
                            document.getElementById("rolls-count-text").innerText = `${fP} WINS!`;
                        }
                        if(parseInt(document.getElementById("fPPoints").innerText) < parseInt(document.getElementById("sPPoints").innerText)){
                            document.getElementById("rolls-count-text").innerText = `${sP} WINS!`;
                        }
                        document.getElementById("roll-the-dice").remove();
                        document.getElementById("button-holder").innerHTML = '<a href = "index.php"><input type="button" id="main-menu" class="roll-the-dice" value="Main Menu" </input></a>';

                        document.cookie = "firstScore="+ parseInt(document.getElementById("fPPoints").innerHTML);
                        document.cookie = "secondScore="+ parseInt(document.getElementById("sPPoints").innerHTML);
                        document.cookie = "fName="+fP;
                        document.cookie = "sName="+sP;
                        <?php
                        $param = $_COOKIE["firstScore"];
                        $paramTwo = $_COOKIE["secondScore"];
                        $pF = $_COOKIE["fName"];
                        $sF = $_COOKIE["sName"];
                        $stmt = $mysqli->prepare("update players set score=? where email=?");
                        $stmt->bind_param("is", $param, $pF);
                        $stmt->execute();
                        $stmt->close();

                        $stmt = $mysqli->prepare("update players set score=? where email=?");
                        $stmt->bind_param("is", $paramTwo, $sF);
                        $stmt->execute();
                        $stmt->close();
                        ?>

                        return;


                    }



                    var diceRes = Math.floor(Math.random() * 6)+1;
                    document.getElementById("dice").parentNode.removeChild(document.getElementById("dice"));
                    document.getElementById("diceImg").innerHTML = `<img id="dice" class="dice-img" src="Dice-${diceRes}.png"/>`;

                    if (document.getElementById("player-name").textContent == fP){
                        document.getElementById("fPPoints").innerHTML = parseInt(document.getElementById("fPPoints").innerText)+diceRes;
                        document.getElementById("spinsFP").innerHTML = fPNumberOfRows-1;
                        document.getElementById("player-name").innerHTML = sP;
                    }
                    else{
                        document.getElementById("player-name").innerHTML = fP;
                        document.getElementById("sPPoints").innerHTML = parseInt(document.getElementById("sPPoints").innerText)+diceRes;
                        document.getElementById("spinsSP").innerHTML = sPNumberOfRows-1;

                    }
                }

                function seeLeaders(){
                    {
                        <?php

                        // ia toate randurile din db

                        $stmt = $mysqli->prepare("SELECT * FROM players");
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                        $stmt->close();
                        ?>
                        document.getElementById("arrayOFLEADERS").innerHTML = '<h2>Lista studenti</h2> <table> <thead> <th>Id</th> <th>Name</th> <th>Score</th> </thead> <tbody><?php foreach ($result as $row) {?><tr> <td><?php echo $row['ID'] ?></td> <td><?php echo $row['email'] ?></td> <td><?php echo $row['score'] ?></td> </tr><?php }?></tbody> </table>';
                    }
                }
            </script>
            <p>
                <div id="diceImg">
                    <img id="dice" class="dice-img" src="Dice-<?php echo rand(1,6);?>.png"/>
                </div>
            </p>

            <div id="arrayOFLEADERS">

            </div>
        </div>

    </body>
<?php


?>