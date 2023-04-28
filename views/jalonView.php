<div class="allContainer position-relative">
    <?php include "components/postHead.php" ?>

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

    <?php include "components/postFooter.php" ?>

    <script src="/src/jalon.js"></script>
</div>