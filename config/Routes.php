<?php

namespace App\Config\Routes;

class Routes
{

  private $routes = array();

  public function add($path, $http_method, $callback)
  {
    // convert any parameterized parts of the path to regular expressions
    $path_regex = preg_replace('/{([a-zA-Z0-9_-]+)}/', '([a-zA-Z0-9_-]+)', $path);
    $path_regex = str_replace('/', '\/', $path_regex);
    // add a new route to the routes array
    $this->routes[] = array(
      'path' => $path,
      'path_regex' => $path_regex,
      'http_method' => $http_method,
      'callback' => $callback
    );
  }

  public function dispatch()
  {
    // get the current path and http method
    $path = $_SERVER['REQUEST_URI'];
    $http_method = $_SERVER['REQUEST_METHOD'];

    // loop through the routes and find a matching route
    foreach ($this->routes as $route) {
      if ($route['http_method'] == $http_method) {
        // check if the path matches the route's regular expression
        if (preg_match('/^' . $route['path_regex'] . '$/', $path, $matches)) {
          // remove the first match, which is the full path
          array_shift($matches);
          // call the callback function with any parameters
          call_user_func_array($route['callback'], $matches);
          return;
        }
      }
    }

    // if no route is found, show a 404 error page
    http_response_code(404);
    echo 'Page not found';
  }
}