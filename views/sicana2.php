<script src="/src/sicana.js"></script>
<div class="">
    <div class="body ">
        <div class="headerSicana" data-sicana="2">
            <div class="activeRow text-center my-5">
                <h1 class="active text-center">
                    <div class="w-100 mx-auto d-flex justify-content-center">
                        <div class="w-100">

                            <h3>Nr. Concurent:</h3>
                            <h3 class="">
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
                </h1>
            </div>
            <div class="nextOrPreview text-center">
                <button class="btn btn-warning m-2 back">Inapoi</button>
                <button class="btn btn-success m-2 next">Urmatorul</button>
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
            <h4>Sicanele 1 si 3</h4>
            <button class="btn btn-primary treceriBtn">Trecerea 1</button>
        </div><br><br>

        <div class="text-center my-4">
            <h4>Export CSV</h4>
            <button class="btn btn-primary" onclick="exportCSV()">Export</button>
        </div>
    </div>
</div>