<?php

define("RECAPTCHA_V3_SECRET_KEY", '<SECRET>');

$token = isset($_POST['token']) ? $_POST['token'] : "";
$action = isset($_POST['action']) ? $_POST['action'] : "";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);

$validCaptcha = false;
$validUser = false;
// verify the response
if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    $validCaptcha = true;
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
}

if (!$validCaptcha) {
    header("Location: index.php?fail=1");
    exit;
}
if (!$validUser) {
    header("Location: index.php?fail=2");
    exit;
}

echo "Welcome " . $username;
