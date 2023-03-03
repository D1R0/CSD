<?php
if (isset($_POST["command"])) {
    if (($_POST["command"]) == "playerActive") {
        $myfile = fopen("../data/sessionPlayer.txt", "w");
        $txt = $_POST["active"];
        fwrite($myfile, $txt);
        fclose($myfile);
        writeLog("======== concurent:" . $txt);

    }

    if ($_POST["command"] == "read") {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(getActivePlayer());
    }
    if ($_POST["command"] == "timp") {
        $row_identifier = getActivePlayer();
        $timp = $_POST["timp"];
        writeLog("timp: " . $timp);
        $fileName = "../data/penalizari.txt";
        $myfile = fopen($fileName, "r") or die("Unable to open file!");
        $penalizari = explode(",",fread($myfile, filesize($fileName)));
        fclose($myfile);
        $myfile = fopen("../data/penalizari.txt", "w");
        fwrite($myfile, "");
        fclose($myfile);
        $totalPenalizari=0;
        foreach($penalizari as $penalizare){
            try{ 
                $totalPenalizari+= (int) $penalizare;
            }catch (Exception $e){
                
            }
        }
        replace_value("../data/concurentiTimp.csv", $row_identifier, $timp,$totalPenalizari);
    }
    if ($_POST["command"] == "penalizari") {
        $data = $_POST["data"];
        $jaloane = isset($data["jaloane"]) ? $data["jaloane"] : [];
        $file = fopen("../data/penalizari.txt", "a");
        fwrite($file, $data["total"] . ",");
        fclose($file);
        writeLog("trecere la sicana " . $data["sicana"] . " penalizari: " . implode(",", $jaloane) . " Total secunde " . $data["total"]);
    }
}
function getActivePlayer()
{
    $fileName = "../data/sessionPlayer.txt";
    $myfile = fopen($fileName, "r") or die("Unable to open file!");
    $player = fread($myfile, filesize($fileName));
    fclose($myfile);
    return $player;
}
function replace_value($csv_file, $row_identifier, $new_value,$totalPenalizari)
{
    // Create a temporary file
    $temp_file = tempnam(sys_get_temp_dir(), 'csv');

    // Open the CSV file using SplFileObject
    $file = new SplFileObject($csv_file, 'r');

    // Open the temporary file using SplFileObject
    $temp = new SplFileObject($temp_file, 'w');

    // Loop through each row in the file
    while (!$file->eof()) {
        // Get the current row as an array of values
        $row = $file->fgetcsv();

        // Check if the row identifier matches
        if ($row[0] == $row_identifier) {
            // Modify the value in the row array
            $row[5] = $new_value;
            $row[6] = $totalPenalizari;
        }

        // Write the row to the temporary file
        $temp->fputcsv($row);
    }

    // Close both files
    $file = null;
    $temp = null;

    // Replace the original file with the temporary file
    unlink($csv_file);
    rename($temp_file, $csv_file);

    // Return true to indicate success
    return true;
}

function writeLog($string)
{
    $file = fopen("../data/istoric.log", "a");
    $time = date("Y-m-d H:i:s");
    fwrite($file, "$time: $string" . PHP_EOL);
    fclose($file);
}