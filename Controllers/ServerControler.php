<?php

namespace App\Controllers\ServerControler;


class ServerControler
{
    protected $sesPlayerDir;
    protected $istoricDir;
    protected $penalizariDir;
    function __construct()
    {
        $this->sesPlayerDir = "data/sessionPlayer.txt";
        $this->istoricDir = "data/istoric.log";
        $this->penalizariDir = "data/penalizari.txt";
    }
    function apiServices()
    {
        if (isset($_POST["command"])) {
            if (($_POST["command"]) == "playerActive") {
                $myfile = fopen($this->sesPlayerDir, "w");
                $txt = $_POST["active"];
                fwrite($myfile, $txt);
                fclose($myfile);
                $this->writeLog("======== concurent:" . $txt);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($this->getActivePlayer());
            }
            if (($_POST["command"]) == "clearDb") {

                unlink("data/concurentiTimp.csv");
                unlink($this->istoricDir);
                copy("data/concurentiOrigin.csv", "data/concurentiTimp.csv");
                $myfile = fopen($this->istoricDir, "w");
                fclose($myfile);
            }
            if ($_POST["command"] == "read") {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($this->getActivePlayer());
            }
            if ($_POST["command"] == "clean") {
                $myfile = fopen($this->penalizariDir, "w");
                fwrite($myfile, "");
                fclose($myfile);
            }
            if ($_POST["command"] == "timp") {
                $row_identifier = $this->getActivePlayer();
                $timp = $_POST["timp"];
                $this->writeLog("timp: " . $timp);
                $fileName = $this->penalizariDir;
                echo $fileName;
                $myfile = fopen($fileName, "r");
                $penalizari = explode(",", fread($myfile, filesize($fileName)));
                fclose($myfile);
                $myfile = fopen($this->penalizariDir, "w");
                fwrite($myfile, "");
                fclose($myfile);
                $totalPenalizari = 0;
                foreach ($penalizari as $penalizare) {
                    try {
                        $totalPenalizari += (int) $penalizare;
                    } catch (\Exception $e) {
                    }
                }
                $this->replace_value("data/concurentiTimp.csv", $row_identifier, $timp, $totalPenalizari);
            }
            if ($_POST["command"] == "penalizari") {
                $data = $_POST["data"];
                $jaloane = isset($data["jaloane"]) ? $data["jaloane"] : [];
                $file = fopen($this->penalizariDir, "a");
                fwrite($file, $data["total"] . ",");
                fclose($file);
                $this->writeLog("trecere la " .  $data["sectiune"] . " penalizari: " . implode(",", $jaloane) . " Total secunde " . $data["total"]);
            }
        }
    }
    function getActivePlayer()
    {
        $fileName = $this->sesPlayerDir;
        $myfile = fopen($fileName, "r") or die("Unable to open file!");
        $player = fread($myfile, filesize($fileName));
        fclose($myfile);
        return $player;
    }
    function replace_value($csv_file, $row_identifier, $new_value, $totalPenalizari)
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'csv');

        $file = new \SplFileObject($csv_file, 'r');

        $temp = new \SplFileObject($temp_file, 'w');

        while (!$file->eof()) {
            $row = $file->fgetcsv();
            if ($row[0] == $row_identifier) {
                $row[5] = $new_value;
                $row[6] = $totalPenalizari;
            }

            $temp->fputcsv($row);
        }

        $file = null;
        $temp = null;

        unlink($csv_file);
        rename($temp_file, $csv_file);

        // Return true to indicate success
        return true;
    }

    function writeLog($string)
    {
        $file = fopen($this->istoricDir, "a");
        $time = date("Y-m-d H:i:s");
        fwrite($file, "$time: $string" . PHP_EOL);
        fclose($file);
    }
}
