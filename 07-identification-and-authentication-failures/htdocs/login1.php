<?php

$validUser = false;
$myfile = fopen("users.json", "r") or die("Unable to open file!");
$usersStr = fread($myfile, filesize("users.json"));
fclose($myfile);

$users = json_decode($usersStr, true);
$username = array_key_exists("username", $_POST) ? $_POST["username"] : "";
$password = array_key_exists("password", $_POST) ? $_POST["password"] : "";

foreach($users as $user) {
    if ($user["username"] == $username) {
        if ($user["password"] == $password) {
            $validUser = true;
        }
        break;
    }
}

if (!$validUser) {
    header("Location: index.php?fail=2");
    exit;
}

echo "Welcome " . $username;
