<?php

require_once("User.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = null;
    if ($username == "admin" && $password == "admin") {
        $user = new User($username, 1);
    } else if ($username == "user" && $password == "123456") {
        $user = new User($username, 2);
    } else {
        header("Location: index.php");
        exit;
    }

    $serializedUser = serialize($user);
    $cookieVal = base64_encode($serializedUser);

    setcookie("owasp-session", $cookieVal, time() + (86400 * 30), "/");
    header("Location: home.php");
} else {
    header("Location: index.php");
}
