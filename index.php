<?php
  
$path =str_replace("/index.php","",$_SERVER['REQUEST_URI'])=="/" ? "/index"  : str_replace("/index.php","",$_SERVER['REQUEST_URI']) ;

$dir = 'Controllers/*.php';
foreach (glob($dir) as $file) {
    include $file;
}
require_once "routes/rest.php";

