<script src="/src/sicana.js"></script>
<div class="allContainer">
    <div class="header" data-sicana="<?php echo $id; ?>">
        <div class="activeRow text-center py-5">
            <!-- <h1 class="active text-center"> -->
            <h1> Sicana
                <?php echo $id; ?>
            </h1>
            <div class="w-100 mx-auto d-flex justify-content-center">
                <div class="w-100">

                    <h3>Nr. Concurent:</h3>
                    <h3 class="concurentActiv">
                        <?php $fileName = "data/sessionPlayer.txt";
                        $myfile = fopen($fileName, "r") or die("Unable to open file!");
                        $player = fread($myfile, filesize($fileName));
                        fclose($myfile);
                        echo $player; ?>
                    </h3>
                </div>

            </div>
            <div class="w-100">
                <h4 class="auto"></h4>
                <h4 class="clasa"></h4>
            </div>
        </div>
    </div>
    <hr>
    <div class="jaloaneSectiune">
        <div class="checkButtons text-left" id="Elementul 1">
            <label>
                <input type="checkbox" name="option1" value="Option 1" data-penalizare="10" id="E13">
                E1_3
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label>
                <input type="checkbox" name="option2" value="Option 2" data-penalizare="10" id="E12">
                E1_2
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label>
                <input type="checkbox" name="option3" value="Option 3" data-penalizare="5" id="E11">
                E1_1
            </label><br><br><br>
        </div>

        <div class="checkButtons text-center" id="Elementul 2">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label>
                <input type="checkbox" name="option4" value="Option 4" data-penalizare="5" id="E21">
                E2_1
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label>
                <input type="checkbox" name="option5" value="Option 5" data-penalizare="10" id="E22">
                E2_2
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label>
                <input type="checkbox" name="option6" value="Option 6" data-penalizare="10" id="E23">
                E2_3
            </label><br><br><br>
        </div>

        <div class="checkButtons text-left" id="Elementul 3">
            <label>
                <input type="checkbox" name="option7" value="Option 7" data-penalizare="5" id="E33">
                E3_3
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label>
                <input type="checkbox" name="option8" value="Option 8" data-penalizare="10" id="E32">
                E3_2
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label>
                <input type="checkbox" name="option9" value="Option 9" data-penalizare="5" id="E31">
                E3_1
            </label><br><br><br>
        </div>
    </div>
    <div class="text-center my-4">
        <button class="btn btn-primary treceriBtn">Trecere</button>
    </div>
    <br>
    <br>
    <div class="localLog bg-warning vw-100 ">
        <p>Log Section</p>
    </div>
</div>