<?php

use App\Controllers\ServerControler\ServerControler;
use App\Config\Routes\Routes;

session_start();
$routes = new Routes();

$routes->add('/sicana/{id}', 'GET', function ($id) {
    $services = new ServerControler();
    $posturi = $services->posturi();
    if (in_array($id, array_keys($posturi["sicana"]))) {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == "sicana" || $_SESSION['role'] == "admin") {
                render($posturi["sicana"][$id], ['id' => $id, 'type' => "Sicana"]);
            } else {
                render("logout");
            }
        } else {
            render("login");
        }
    }
});
$routes->add('/jalon/{id}', 'GET', function ($id) {
    $services = new ServerControler();
    $posturi = $services->posturi();
    if (in_array($id,  array_keys($posturi["jalon"]))) {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == "jalon" || $_SESSION['role'] == "admin") {
                render($posturi["jalon"][$id], ['id' => $id, 'type' => "Jalon"]);
            } else {
                render("logout");
            }
        } else {
            render("login");
        }
    }
});
$routes->add('/mod', 'GET', function () {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == "mod" || $_SESSION['role'] == "admin") {
            render("mod");
        } else {
            render("logout");
        }
    } else {
        render("login");
    }
});

$routes->add('/admin', 'GET', function () {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == "admin") {
            $services = new ServerControler();
            $posturi = $services->posturi();
            render("admin", ["posturi" => $posturi]);
        } else {
            render("logout");
        }
    } else {
        render("login");
    }
});
$routes->add('/start-stop', 'GET', function () {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == "startstop" || $_SESSION['role'] == "admin") {
            render("start-stop");
        } else {
            render("logout");
        }
    } else {
        render("login");
    }
});
$routes->add('/auth', 'GET', function () {
    render("auth");
});
$routes->add('/', 'GET', function () {
    render("onlyview");
});
$routes->add('/logout', 'GET', function () {
    render("logout");
});
$routes->add('/download', 'GET', function () {
    $services = new ServerControler();
    return $services->download();
});

function render($view, $param = [])
{

    require_once("components/header.php");
    extract($param);
    require_once('views/' . $view . '.php');
    require_once("components/footer.php");
}
$routes->add('/api/services', 'POST', function () {
    $services = new ServerControler();
    print_r($services->apiServices());
});
$routes->dispatch();
