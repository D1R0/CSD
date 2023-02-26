<?php
  
$path = $_SERVER['REQUEST_URI'];
if($path=="/test"){
    require_once "views/test.php";
}