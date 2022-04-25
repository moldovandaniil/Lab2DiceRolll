<?php

if (isset($_POST['numberOfRolls'])){
    $numberOfRolls = intval($_POST['numberOfRolls']);
}
else{
?>
    <head>
        <title>DiceRoll Game!</title>
    </head>

    <body>
        <h5> Nu s-a putut conecta</h5>

    </body>
<?php
}