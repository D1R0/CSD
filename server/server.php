<?php

if($_POST["command"]=="write"){
    $myfile = fopen("../data/sessionPlayer.txt", "w");
    $txt = $_POST["active"];
    fwrite($myfile, $txt);
    fclose($myfile);
}

if($_POST["command"]=="read"){
    $fileName="../data/sessionPlayer.txt";
    $myfile = fopen($fileName, "r") or die("Unable to open file!");
    $player= fread($myfile,filesize($fileName));
    fclose($myfile);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($player);
}
if($_POST["command"]=="timp"){
    $time=$_POST["time"];
    $fileName="../data/sessionPlayer.txt";
    $myfile = fopen($fileName, "r") or die("Unable to open file!");
    $player= fread($myfile,filesize($fileName));
    $concurenti="../data/concurenti.txt";
    $concurentifile = fopen($concurenti, "r") or die("Unable to open file!");
    $concurentiData= fread($myfile,filesize($fileName));
    fclose($myfile);
}