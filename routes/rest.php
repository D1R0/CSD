<?php

use App\Controllers\ServerControler\ServerControler;
use App\Controllers\Routes\Routes;

session_start();
$routes = new Routes();

$routes->add('/sicana/{id}', 'GET', function ($id) {
    $sicaneList = [2, 13];
    if (in_array($id, $sicaneList)) {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == "sicana") {
                render("sicana", ['id' => $id]);
            } else {
                render("logout");
            }
        } else {
            render("login");
        }
    }
});
$routes->add('/jalon/{id}', 'GET', function ($id) {
    $jalonList = [1, 4, 23];
    if (in_array($id, $jalonList)) {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == "jalon") {
                render("jalon", ['id' => $id]);
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
        if ($_SESSION['role'] == "mod") {
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
            render("admin");
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
$routes->add('/start-stop', 'GET', function () {
    render("start-stop");
});
$routes->add('/logout', 'GET', function () {
    render("logout");
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
