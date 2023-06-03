<?php

namespace App\Controllers\ServerControler;

use DateTime;
use DateTimeImmutable;
use ZipArchive;


class ServerControler
{
    protected $queuePlayerDir;
    protected $start_sosire;
    protected $sesPlayerDir;
    protected $istoricDir;
    protected $penalizariDir;
    protected $settings;
    function __construct()
    {
        $this->queuePlayerDir = "data/queue.txt";
        $this->start_sosire = "data/start_sosire.txt";
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
            if ($_POST["command"] == "process") {
                $data = $_POST["data"];
                if ($data['post'] != "start" && $data['post'] != "sosire") {
                    $elements = isset($data["elemente"]) ? implode(",", $data["elemente"]) : "0";
                    $this->writePenalties($data);
                    $this->writeLog("Concurent:" .  $data["concurent"] . ", Post:" .  $data["post"] . ", elemente lovite:" . $elements . ", Total secunde:" . $data["total"]);
                } else if ($data['post'] == "sosire") {
                    $stopTime = DateTimeImmutable::createFromFormat('U.u', sprintf('%.6F', microtime(true)))->format('Y-m-d H:i:s.u');
                    $resume = $this->calculateTimeDiffAndPenalties($stopTime, $data);
                    $this->writeLog("Concurent stop:" .  $data["concurent"]);
                    $new_value = $resume['timeDiff'];
                    $totalPenalizari = $resume['penalties'];
                    $row_identifier = $this->getPlayerNumber($data["concurent"]);
                    $this->replace_value("data/concurentiTimp.csv", $row_identifier, $new_value, $totalPenalizari);
                } else {
                    $this->writeStart($data);
                    $this->writeLog("Concurent start:" .  $data["concurent"]);
                }
            }
        }
    }
    function writeStart($data)
    {
        $indexC = $data['concurent'];
        $type = $data['post'];
        $time = DateTimeImmutable::createFromFormat('U.u', sprintf('%.6F', microtime(true)))->format('Y-m-d H:i:s.u');
        $logString = $type . '_' . $indexC . '_' . $time . ", ";

        $lines = file($this->start_sosire, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updatedLines = [];

        $isExistingEntry = false;
        foreach ($lines as $line) {
            $lineParts = explode('_', $line);
            if ($lineParts[0] === $type && $lineParts[1] === $indexC) {
                $updatedLines[] = $logString; // Overwrite the existing entry
                $isExistingEntry = true;
            } else {
                $updatedLines[] = $line;
            }
        }

        if (!$isExistingEntry) {
            $updatedLines[] = $logString;
        }

        $file = fopen($this->start_sosire, 'w');
        fwrite($file, implode("\n", $updatedLines));
        fclose($file);
    }

    function calculateTimeDiffAndPenalties($stopTime, $data)
    {
        $startTime = '';
        $indexC = $data['concurent'];
        $logLines = file($this->start_sosire, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($logLines as $line) {
            $lineParts = explode('_', $line);
            if ($lineParts[1] === $indexC) {
                $startTime = $lineParts[2];
                break;
            }
        }
        $startTimeNew = str_replace(", ", "", $startTime);
        $startTimeObj = DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $startTimeNew);
        $stopTimeObj = DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $stopTime);
        $diff = $stopTimeObj->diff($startTimeObj);
        $minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
        $seconds = $diff->s;
        $milliseconds = floor($diff->f * 1000);
        $finalFormatTime = sprintf('%d:%02d.%03d', $minutes, $seconds, $milliseconds);
        $penalties = 0;
        $penaltiesLines = file($this->penalizariDir, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($penaltiesLines as $line) {
            $lineParts = explode('_', $line);
            if ($lineParts[0] === $indexC) {
                $penalties += intval($lineParts[1]);
            }
        }

        $formattedPenalties = sprintf('%02d:%02d.00', floor($penalties / 60), $penalties % 60);
        return [
            'timeDiff' => $finalFormatTime,
            'penalties' => $formattedPenalties
        ];
    }
    function writePenalties($data)
    {
        $indexC = $data['concurent'];

        $penalties = $data['total'];
        $file = fopen($this->penalizariDir, 'a');
        fwrite($file, $indexC . "_" . $penalties . "\n");
        fclose($file);

        return $penalties;
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
        echo  $row_identifier;
        $temp_file = tempnam(sys_get_temp_dir(), 'csv');

        $file = new \SplFileObject($csv_file, 'r');

        $temp = new \SplFileObject($temp_file, 'w');

        while (!$file->eof()) {
            $row = $file->fgetcsv();
            echo $row[0];
            if ($row[0] == $row_identifier) {

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

        return true;
    }
    function getPlayerNumber($id)
    {
        $fileName = $this->queuePlayerDir;
        $myfile = fopen($fileName, "r") or die("Unable to open file!");
        $queue = fread($myfile,  filesize($this->queuePlayerDir) > 0 ?  filesize($this->queuePlayerDir) : 1);
        $pattern = "/{$id}=(\d+)/";
        preg_match($pattern, $queue, $matches);

        if (isset($matches[1])) {
            return $matches[1];
        }

        return null; // Return null if player number is not found
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
                "start" => "templates/start",
                "sosire" => "templates/sosire",
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
        $this->start_sosire = "data/start_sosire.txt";
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
        if (!file_exists($this->start_sosire)) {
            file_put_contents($this->start_sosire, "");
        }
        return true;
    }
}
