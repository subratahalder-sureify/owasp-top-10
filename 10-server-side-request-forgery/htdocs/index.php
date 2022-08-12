<?php

if (isset($_GET['url'])) {
    $url = $_GET['url'];
}

$image = fopen($url, 'rb');

header("Content-Type: image/png");

fpassthru($image);
