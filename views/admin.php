<html>

<head>
    <?php
    require_once("components/header.php")
    ?>
</head>

<body>
    <script src="/src/admin.js"></script>
    <div class="adminPannel w-100 bg-light p-5 text-center vh-100">
        <div class="details">
            <p>concurent pe traseu</p>
            <p class="">
                <?php $fileName = "data/sessionPlayer.txt";
                $myfile = fopen($fileName, "r") or die("Unable to open file!");
                $player = fread($myfile, filesize($fileName));
                fclose($myfile);
                echo $player; ?>
            </p>
        </div>
        <button class="btn btn-danger clearData" onclick="$('.popup').show()">Wipe</button>
        <div class="popup bg-light p-5">
            <p>Esti sigur?</p>
            <hr>
            <div class="d-flex m-4">
                <button class="btn btn-danger m-2" onclick="clearDatas();">Da</button>
                <button class="btn btn-warning m-2" onclick="$('.popup').hide()">Nu</button>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.1.0/papaparse.min.js"></script>

</body>

</html>