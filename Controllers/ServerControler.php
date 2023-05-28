<?php

namespace App\Controllers\ServerControler;

use ZipArchive;


class ServerControler
{
    protected $queuePlayerDir;
    protected $sesPlayerDir;
    protected $istoricDir;
    protected $penalizariDir;
    protected $settings;
    function __construct()
    {
        $this->queuePlayerDir = "data/queue.txt";
        $this->sesPlayerDir = "data/sessionPlayer.txt";
        $this->istoricDir = "data/istoric.log";
        $this->penalizariDir = "data/penalizari.txt";
        $jsonString = file_get_contents('Controllers/settings.json');
        $this->settings = json_decode($jsonString, true);
    }
    function apiServices()
    {
        if (isset($_POST["command"])) {
            if (($_POST["command"]) == "playerActive") {
                if ($this->settings['type'] == "start->stop") {
                    $myfile = fopen($this->queuePlayerDir, "r+");
                    $txt = count(explode(",", fread($myfile, filesize($this->queuePlayerDir) > 0 ?  filesize($this->queuePlayerDir) : 1))) . "=" . $_POST["active"];
                    fwrite($myfile, $txt . ",");
                    fclose($myfile);
                    $this->writeLog("======== concurent:" . $txt);
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($this->getActivePlayer());
                } else {
                    $myfile = fopen($this->sesPlayerDir, "w");
                    $txt = $_POST["active"];
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $this->writeLog("======== concurent:" . $txt);
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($this->getActivePlayer());
                }
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
            if ($_POST["command"] == "startSession") {
                $auth = $_POST['data'];
                $this->auth($auth);
            }
            if ($_POST["command"] == "timp") {
                $row_identifier = explode(" ", $this->getActivePlayer())[0];
                $timp = $_POST["timp"];
                $this->writeLog("timp: " . $timp);
                $fileName = $this->penalizariDir;
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
                $penalties = isset($data["penalties"]) ? $data["penalties"] : [];
                $file = fopen($this->penalizariDir, "a");
                fwrite($file, $data["total"] . ",");
                fclose($file);
                $this->writeLog("trecere la " .  $data["sectiune"] . " penalizari: " . implode(",", $penalties) . " Total secunde " . $data["total"]);
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
                echo $row[0];
                $row[5] = $new_value;
                $row[6] = $totalPenalizari;
                print_r($row);
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
    private function auth($user)
    {
        $success = false;
        $users = [
            "user1" => [
                "id" => "operator",
                "pass" => "operatorcsd23",
                "role" => "post"
            ],
            "user2" => [
                "id" => "jalon",
                "pass" => "jaloncsd23",
                "role" => "jalon"
            ],
            "user3" => [
                "id" => "startstop",
                "pass" => "startstopcsd23",
                "role" => "startstop"
            ],
            "user4" => [
                "id" => "admin",
                "pass" => "admincsd23",
                "role" => "admin"
            ],
            "user5" => [
                "id" => "mod",
                "pass" => "modcsd23",
                "role" => "mod"
            ]
        ];
        foreach ($users as $key => $value) {
            if ($value["id"] == $user["username"]) {
                if ($value["pass"] == $user["password"]) {
                    $success = true;
                    $role = $value["role"];
                }
            }
        }
        if ($success == true) {
            echo json_encode(['result' => $success, ['user' => $user["username"], 'role' => $role]]);
        } else {

            echo json_encode(['result' => $success]);
        }
    }
    public function posturi()
    {

        $posturiPeriam = [
            "sicana" => [
                2 => "templates/sicanaView",
                13 => "templates/sicanaView"
            ],
            "jalon" => [
                1 => "templates/jalonSimplu",
                4 => "templates/jalonSimplu",
                23 => "templates/opturi",
            ]
        ];
        $posturi = [
            "post" => [
                1 => "templates/s2sj",
                2 => "templates/4sj",
                3 => "templates/3sj",
                4 => "templates/2sj",
                5 => "templates/5sj",
                6 => "templates/4sj",
                7 => "templates/5sj",
                8 => "templates/4sj",
                9 => "templates/5sj",
                10 => "templates/2sj",
                11 => "templates/sicana5e",
                12 => "templates/sicanaView",
            ],
        ];
        return $posturi;
    }
    public function download()
    {
        $zip = new ZipArchive();

        $zip_filename = 'archive.zip';

        if ($zip->open($zip_filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            die("Failed to create archive\n");
        }

        $zip->addFile('../data/concurentiTimp.csv');
        $zip->addFile('../data/istoric.log');

        $zip->close();

        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . basename($zip_filename));
        header('Content-Length: ' . filesize($zip_filename));

        readfile($zip_filename);
        unlink($zip_filename);
    }
    public function downloadTimpi()
    {
        $file_url = '/concurentiTimp.csv';
        $file_contents = file_get_contents($file_url);
        return $file_contents;
    }
    public function showQueue()
    {
        $list = [];
        $fileContents = file_get_contents('data/queue.txt');
        $items = explode(",", $fileContents);
        foreach ($items as $item) {
            if ($item != "") {
                $list[explode("=", $item)[0]] = explode("=", $item)[1];
            }
        }
        $jsonData = json_encode($list);
        header('Content-Type: application/json');
        return $jsonData;
    }
    public function clearQueue()
    {
        $file = $this->queuePlayerDir;
        $content = '';
        file_put_contents($file, $content);
        print_r("success");
    }
    public function install()
    {
        $this->queuePlayerDir = "data/queue.txt";
        $this->sesPlayerDir = "data/sessionPlayer.txt";
        $this->istoricDir = "data/istoric.log";
        $this->penalizariDir = "data/penalizari.txt";

        if (!file_exists($this->queuePlayerDir)) {
            file_put_contents($this->queuePlayerDir, "");
        }

        if (!file_exists($this->sesPlayerDir)) {
            file_put_contents($this->sesPlayerDir, "");
        }

        if (!file_exists($this->istoricDir)) {
            file_put_contents($this->istoricDir, "");
        }

        if (!file_exists($this->penalizariDir)) {
            file_put_contents($this->penalizariDir, "");
        }
        return true;
    }
}
