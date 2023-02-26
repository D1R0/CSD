<?php
$myfile = fopen("../data/sessionPlayer.txt", "w");
$txt = $_POST["active"];
fwrite($myfile, $txt);
fclose($myfile);