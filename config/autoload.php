<?php
$dir = 'Controllers/*.php';
foreach (glob($dir) as $file) {
    include $file;
}
include "config/Routes.php";
require_once "routes/rest.php";
