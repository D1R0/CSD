<span class="activePlayer">Jucator Activ
    <?php $fileName = "data/sessionPlayer.txt";
    $myfile = fopen($fileName, "r") or die("Unable to open file!");
    $player = fread($myfile, filesize($fileName));
    fclose($myfile);
    echo $player; ?>
</span>