<?php

require 'controllers/CinemaController.php';
require 'controllers/RestaurantController.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
  case 'film':
    $controller = new CinemaController();
    break;
  case 'restaurant':
    $controller = new RestaurantController();
    break;
  default:
    $controller = null;
    break;
}

if ($controller && method_exists($controller, $action)) {
  $controller->{$action}();
} else {
  echo "Page not found";
}
