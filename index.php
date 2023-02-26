<?php
  
$view =str_replace("/index.php","",$_SERVER['REQUEST_URI'])=="/" ? "/index"  : str_replace("/index.php","",$_SERVER['REQUEST_URI']) ;
require_once "views".$view.".php";