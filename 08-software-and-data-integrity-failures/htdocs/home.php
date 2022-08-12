<?php

require_once("User.php");

$cookieVal = $_COOKIE["owasp-session"];
$serializedUser = base64_decode($cookieVal);

$user = unserialize($serializedUser);
if ($user->isAdmin()) {
    echo "Welcome Admin";
} else {
    echo "Welcome User";
}
