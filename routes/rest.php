<?php
use App\Controllers\ServerControler\ServerControler;
use App\Controllers\Routes\Routes;

$routes = new Routes();

$routes->add('/sicana/{id}', 'GET', function ($id) {
    $sicaneList = [2, 13];
    if (in_array($id, $sicaneList)) {
        render("sicana", ['id' => $id]);
    }
});
$routes->add('/jalon/{id}', 'GET', function ($id) {
    $jalonList = [1, 4, 23];
    if (in_array($id, $jalonList)) {
        render("jalon", ['id' => $id]);
    }
});
$routes->add('/mod', 'GET', function () {
    render("mod");
});
$routes->add('/admin', 'GET', function () {
    render("admin");
});
$routes->add('/', 'GET', function () {
    render("onlyview");
});
$routes->add('/start-stop', 'GET', function () {
    render("start-stop");
});
$routes->add('/api/services', 'POST', function () {
    $services = new ServerControler();
    print_r($services->apiServices());
});

$routes->dispatch();
function render($view, $param = [])
{
    extract($param);
    require_once('views/' . $view . '.php');
}