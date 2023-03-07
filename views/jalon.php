<html>

<head>
    <?php
    require_once("components/header.php")
        ?>
</head>

<body>

    <div class="header " data-jalon="<?php echo $id?>">
        <div class="activeRow text-center my-5">
            <h1 class="active text-center">
                <h1> Jalon
                    <?php echo $id; ?>
                </h1>
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
            </h1>
        </div>
    </div>
    <hr>
    <div class="checkButtons text-center" id="Elementul 2">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label>
            <input type="checkbox" name="option6" value="Option 6" id="J4" data-penalizare="5">
            Jalon 4
        </label><br><br><br>
    </div>

    <div class="text-center my-4">
        <button class="btn btn-primary treceriBtn">Trecere</button>
    </div>
<script src="/src/jalon.js"></script>
</body>

</html>