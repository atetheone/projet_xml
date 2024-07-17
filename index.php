<?php
session_start();
require_once 'controllers/AuthController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/CinemaController.php';
require_once 'controllers/RestaurantController.php';

// Définir le contrôleur et l'action par défaut
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Router les requêtes vers les contrôleurs appropriés
switch ($controller) {
  case 'auth':
    $authController = new AuthController();
    if ($action === 'login') {
      $authController->login();
    } elseif ($action === 'logout') {
      $authController->logout();
    } else {
      echo "Action non trouvée";
    }
    break;

  case 'home':
    $homeController = new HomeController();
    if ($action === 'index') {
      $homeController->index();
    } else {
      echo "Action non trouvée";
    }
    break;
  
  case 'film':
    $cinemaController = new CinemaController();
    if ($action === 'index') {
      $cinemaController->index();
    } elseif ($action === 'add') {
      $cinemaController->add();
    } elseif ($action === 'edit') {
      $cinemaController->edit();
    } elseif ($action === 'delete') {
      $cinemaController->delete();
    } else {
      echo "Action non trouvée";
    }
    break;
  
  case 'restaurant':
    $restaurantController = new RestaurantController();
    if ($action === 'index') {
      $restaurantController->index();
    } elseif ($action === 'add') {
      $restaurantController->add();
    } elseif ($action === 'edit') {
      $restaurantController->edit();
    } elseif ($action === 'delete') {
      $restaurantController->delete();
    } else {
      echo "Action non trouvée";
    }
    break;

  default:
    echo "Contrôleur non trouvé";
    break;
}
