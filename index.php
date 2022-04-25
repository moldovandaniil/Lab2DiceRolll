<?php



$host = "localhost";
$username = "root";
$password = "";
$dbName = "diceRoll_db";

$mysqli = new mysqli("localhost", "root", "", "diceRoll_db");

$numErr = $oneErr = $twoErr= "";
$canSubmitOne = false;
$canSubmitTwo = false;
$numberOfRolls = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["one"])) {
        $oneErr = "Name is required";
        $canSubmitOne = false;
    } else {
        $canSubmitOne = true;
        /*$firstPlayer = $_POST["one"];
        $stmt = $mysqli->prepare("SELECT * FROM players WHERE email = ?");
        $stmt->bind_param("s", $_POST['one']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows>0){}
        else{
            $createStmt = $mysqli->prepare("INSERT INTO players (email,score) VALUES (?, 0)");
            $createStmt->bind_param("s", $firstPlayer);
            $createStmt->execute();
            $createStmt->close();
        }*/
    }

    if (empty($_POST["two"])) {
        $twoErr = "Name is required";
        $canSubmitTwo = false;
    } else {
        $canSubmitTwo = true;
        /*
        $secondPlayer = $_POST["two"];
        $stmt = $mysqli->prepare("SELECT * FROM players WHERE email = ?");
        $stmt->bind_param("s", $_POST['two']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows>0){}
        else{
            $createStmt = $mysqli->prepare("INSERT INTO players (email,score) VALUES (?, 0)");
            $createStmt->bind_param("s", $secondPlayer);
            $createStmt->execute();
            $createStmt->close();
        }*/
    }
$numRollsExist = false;
    if (empty($_POST["numberOfRolls"])) {
        $numErr = "Number of Rolls is required";
    } else {
        if(intval($_POST["numberOfRolls"]) > 5)
            $numErr = "Number of Rolls shouldn't exceed 5!";
        else if($canSubmitTwo && $canSubmitOne){
            $numRollsExist = true;
            $numberOfRolls = intval($_POST["numberOfRolls"]);
        }
    }

    if ($canSubmitOne && $canSubmitTwo && $numRollsExist){

        $firstPlayer = $_POST["one"];
        $stmt = $mysqli->prepare("SELECT * FROM players WHERE email = ?");
        $stmt->bind_param("s", $_POST['one']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows>0){}
        else{
            $createStmt = $mysqli->prepare("INSERT INTO players (email,score) VALUES (?, 0)");
            $createStmt->bind_param("s", $firstPlayer);
            $createStmt->execute();
            $createStmt->close();
        }

        $secondPlayer = $_POST["two"];
        $stmt = $mysqli->prepare("SELECT * FROM players WHERE email = ?");
        $stmt->bind_param("s", $_POST['two']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows>0){}
        else{
            $createStmt = $mysqli->prepare("INSERT INTO players (email,score) VALUES (?, 0)");
            $createStmt->bind_param("s", $secondPlayer);
            $createStmt->execute();
            $createStmt->close();
        }

        $createStmt = $mysqli->prepare("INSERT INTO games (first_player,second_player, numberOfRolls) VALUES (?, ?,?)");
        $createStmt->bind_param("ssi", $firstPlayer, $secondPlayer, $numberOfRolls);
        $createStmt->execute();
        $createStmt->close();


    }

}





?>
        <link rel = "stylesheet" type="text/css" href="style.css"
    <div class="container">
        <div class="container-close">&times;</div>
        <img
                src="diceImage.jfif"
                alt="image">
        <div class="container-text">
            <h2>Welcome to the Dice Game!</h2>
            <p>Please insert user's <names></names> for the two players <br> in the below brackets.</p>

            <span class="error">* <?php echo $oneErr;?></span>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                 <input type="text" name="one" placeholder="First User Username">
                <span class="error">* <?php echo $twoErr;?></span>

                <input type="text" name="two" placeholder="Second User Username">
                <span class="error">* <?php echo $numErr;?></span>

                 <input type="number" name="numberOfRolls" placeholder="Number of Rolls">
                <button class="submit-continue"  type="submit" >Continue</button>
            </form>
            <?php if($canSubmitTwo && $canSubmitOne && $numRollsExist) {
            header("Location: play_page.php");
            exit();
            }
            ?>
            <span>We will check your last scores</span>
        </div>
    </div>
    <?php



    ?>

