<script src="/src/admin.js"></script>
<div class="bg-light d-flex">
    <div class="adminPannel w-50  p-5 text-center vh-100">
        <div class="details">
            <p>concurent pe traseu</p>
            <p class="concurentActiv">
                <?php $fileName = "data/sessionPlayer.txt";
                $myfile = fopen($fileName, "r") or die("Unable to open file!");
                $player = fread($myfile, filesize($fileName));
                fclose($myfile);
                echo $player; ?>
            </p>
        </div>
        <button class="btn btn-danger clearData" onclick="$('.popup').show()">Wipe</button>
        <a class="btn btn-success" href="/download">Export Data</a>
        <div class="popup bg-light p-5">
            <p>Esti sigur?</p>
            <hr>
            <div class="d-flex m-4">
                <button class="btn btn-danger m-2" onclick="clearDatas();">Da</button>
                <button class="btn btn-warning m-2" onclick="$('.popup').hide()">Nu</button>
            </div>
        </div>
    </div>
    <div class="posturiSchema w-50">

        <table class="table">
            <thead>
                <tr>
                    <th>Tip</th>
                    <th>Post</th>
                    <th>Templates</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posturi as $key => $value) : ?>
                <?php foreach ($value as $id => $view) : ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $view; ?></td>
                    <td><a href="<?php echo "/".$key."/".$id; ?>">View page</a></td>
                </tr>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.1.0/papaparse.min.js"></script>