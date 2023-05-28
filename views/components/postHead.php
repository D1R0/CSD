<div class="header" data-post="<?php echo $id; ?>" data-type="<?php echo $type ?>">
    <div class="activeRow text-center">
        <h1>
            <?php echo  $type . " " . $id; ?>
        </h1>
        <div class="w-100 mx-auto d-flex justify-content-center">
            <div class="w-100">

                <!-- <h3>Nr. Concurent:</h3>
                <h3 class="concurentActiv">
                    <?php $fileName = "data/sessionPlayer.txt";
                    $myfile = fopen($fileName, "r") or die("Unable to open file!");
                    $player = fread($myfile, filesize($fileName) > 0 ?  filesize($fileName) : 1);
                    fclose($myfile);
                    echo $player; ?>
                </h3> -->
                <div class="d-flex flex-wrap justify-content-center selector align-items-center">
                    <div class="col-6 border preview">-</div>
                    <div class="col-8 border actual">-</div>
                    <div class="col-6 border next">-</div>
                </div>
            </div>

        </div>
        <div class="w-100">
            <h4 class="auto"></h4>
            <h4 class="clasa"></h4>
        </div>
    </div>
</div>
<hr>