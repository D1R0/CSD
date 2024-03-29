<?php

namespace App\Controllers\ServerController;

use DateTime;
use DateTimeImmutable;
use ZipArchive;


class ServerController
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

    protected function auth($user)
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
            "user4" => [
                "id" => "admin",
                "pass" => "adminsmy",
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

        // $posturiPeriam = [
        //     "sicana" => [
        //         1 => "templates/sicanaView",
        //         2 => "templates/sicanaView"
        //     ],
        //     "jalon" => [
        //         1 => "templates/jalonSimplu",
        //         2 => "templates/jalonSimplu",
        //     ]
        // ];
        
        $posturi = [
            "post" => [
                "sicana-1" => "templates/sicanaView",
                "sicana-2" => "templates/sicanaView",
                "jalon-1" => "templates/jalonSimplu",
                "jalon-2" => "templates/jalonSimplu",
            ],
        ];
        return $posturi;
    }

    public function install()
    {
        $this->queuePlayerDir = "data/queue.txt";
        $this->sesPlayerDir = "data/sessionPlayer.txt";
        $this->istoricDir = "data/istoric.log";
        $this->penalizariDir = "data/penalizari.txt";
        $this->start_sosire = "data/start_sosire.txt";
        copy("data/concurenti.csv", "data/concurentiTimp.csv");

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
