<div class="allContainer position-relative">
    <div class="header " data-jalon="<?php echo $id ?>">
        <div class="activeRow text-center py-5">
            <!-- <h1 class="active text-center"> -->
            <h1> Jalon
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
        </div>
    </div>

    <hr>
    <div class="checkButtons text-center">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if ($id != "23") {
            echo
            '
            <input type="checkbox" name="option6" value="Option 6" id="J" data-penalizare="5">
            Jalon
        ';
        } else {
            echo '
            <input type="checkbox" name="option5" value="Option 5" id="J2"  data-penalizare="5">
            J2
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      <label>
            <input type="checkbox" name="option6" value="Option 6" id="J3"  data-penalizare="5">
            J3
          </label><br><br><br>
      <label>
            <input type="checkbox" name="option5" value="Option 5" id="P1"  data-penalizare="10">
            Poarta 1
      </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      <label>
            <input type="checkbox" name="option6" value="Option 6" id="P2"  data-penalizare="10">
            Poarta 2
          </label>';
        } ?>

    </div>
    <br>
    <br>
    <div class="text-center my-4">
        <button class="btn btn-primary treceriBtn">Trecere</button>
    </div>
    <div class="localLog bg-warning vw-100 ">
        <p>Log Section</p>
    </div>
    <script src="/src/jalon.js"></script>