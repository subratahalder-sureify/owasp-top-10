<?php

$key = isset($_GET["key"]) ? $_GET["key"] : "";
if ($key != "") {
    file_put_contents('logs.txt', date("Y-m-d H:i:s") . " :: " . $key . "\n\n", FILE_APPEND);
}
