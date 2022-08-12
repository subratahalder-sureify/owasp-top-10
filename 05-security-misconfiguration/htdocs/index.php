<!DOCTYPE html>

<?php

//ini_set('display_errors', 0);

include_once('math/divide.php');

$num1 = "";
$num2 = "";
if (array_key_exists("num1", $_POST) && array_key_exists("num2", $_POST)) {
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];

    $value = divide($num1, $num2);
}

?>

<html>
    <body>
        <form method="POST" action="">
            <div>
                <label>First Number: </label>
                <input type="text" name="num1" value="<?= $num1 ?>" />
            </div>
            <div>
                <label>Second Number: </label>
                <input type="text" name="num2" value="<?= $num2 ?>" />
            </div>
            <input type="submit" value="Divide" />
        </form>
        <?php if (isset($value)) { ?>
        <div>
            <label>Answer: </label>
            <label><?= $value ?></label>
        </div>
        <?php } ?>
    </body>
</html>
