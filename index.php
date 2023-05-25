<?php

$path = str_replace("/index.php", "", $_SERVER['REQUEST_URI']) == "/" ? "/index"  : str_replace("/index.php", "", $_SERVER['REQUEST_URI']);
include "config/autoload.php";
