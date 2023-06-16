<div class="">
    <div class="header ">
        <div class="activeRow text-center my-5">
            <h1 class="active text-center">
                <div class="w-100 mx-auto d-flex justify-content-center">
                    <div class="w-100">

                        <h3>Nr. Concurent:</h3>
                        <h3 class="concurentActiv">
                            <?php $fileName = "data/sessionPlayer.txt";
                            $myfile = fopen($fileName, "r") or die("Unable to open file!");
                            $player = fread($myfile,  filesize($fileName) > 0 ?  filesize($fileName) : 1);

                            fclose($myfile);
                            echo $player; ?>
                        </h3>
                    </div>
                    <div class="w-100">

                        <h1 class="numeConc">-</h1>
                        <h2 class="numePilot">-</h2>
                    </div>
                </div>
                <div class="w-100">
                    <h4 class="auto"></h4>
                    <h4 class="clasa"></h4>
                </div>
            </h1>
        </div>
    </div>
    <hr>
    <div class="actionButtons text-center" id="stopwatch">
        <h2 id="time">00:00.00</h2>
        <button class="btn btn-success m-2 text-white p-4" id="start" onclick="start(this)">Start</button>

    </div>
    <div class="text-center my-4">
        <h4>Export CSV</h4>
        <button class="btn btn-primary" onclick="exportCSV()">Export</button>
    </div>
</div>