<?php

use App\Controllers\ServerController\ServerController;
use App\Config\Routes\Routes;
use App\Controllers\ServicesController\ServicesController;

session_start();
$routes = new Routes();

$routes->add('/post/{id}', 'GET', function ($id) {
    $services = new ServerController();
    $posturi = $services->posturi();
    if (in_array($id, array_keys($posturi["post"]))) {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == "post" || $_SESSION['role'] == "admin") {
                render($posturi["post"][$id], ['id' => $id, 'type' => "Post"]);
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
            $services = new ServerController();
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
$routes->add('/install', 'GET', function () {
    $installer = (new ServerController)->install();
    render("install", ["installer" => $installer]);
});
$routes->add('/', 'GET', function () {
    render("onlyview");
});
$routes->add('/logout', 'GET', function () {
    render("logout");
});

$routes->add('/download', 'GET', function () {
    $services = new ServicesController();
    return $services->downloadTimpi();
});



function render($view, $param = [])
{
    echo "<html>";
    require_once("components/header.php");
    extract($param);
    echo "<body>";

    require_once('views/' . $view . '.php');
    echo "</body>";

    require_once("components/footer.php");
    echo "</html>";
}
$routes->add('/api/services', 'POST', function () {
    $services = new ServicesController();
    print_r($services->apiServices());
});
$routes->add('/api/queue', 'POST', function () {
    $services = new ServicesController();
    print_r($services->showQueue());
});
$routes->add('/api/clearQueue', 'POST', function () {
    $services = new ServicesController();
    print_r($services->clearQueue());
});
$routes->dispatch();
