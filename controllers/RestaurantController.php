<?php
require 'models/Restaurant.php';
require 'models/RestaurantsModel.php';

class RestaurantController {
  private $restaurantsModel;

  public function __construct() {
    $this->restaurantsModel = new RestaurantsModel("xml/restaurants.xml");
  }

  public function index() {
    $restaurants = $this->restaurantsModel->getAllRestaurants();
    include 'views/restaurant/index.php';
  }

  public function show() {
    $id = $_GET['id'];
    $restaurant = $this->restaurantsModel->getRestaurantById($id);
    include 'views/restaurant/show.php';
  }

  public function add() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $restaurant = new Restaurant(
        'r' . uniqid(),
        $_POST['nom'],
        $_POST['adresse'],
        $_POST['restaurateur'],
        $_POST['description'],
        $this->parseCarte($_POST['carte']),
        $this->parseMenus($_POST['menus'])
      );
      $this->restaurantsModel->addRestaurant($restaurant);
      header('Location: index.php?controller=restaurant&action=index');
    } else {
      include 'views/restaurant/add.php';
    }
  }

  public function edit() {
    $id = $_GET['id'];
    $restaurant = $this->restaurantsModel->getRestaurantById($id);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $updatedRestaurant = new Restaurant(
          $id,
          $_POST['nom'],
          $_POST['adresse'],
          $_POST['restaurateur'],
          $_POST['description'],
          $this->parseCarte($_POST['carte']),
          $this->parseMenus($_POST['menus'])
      );
      $this->restaurantsModel->updateRestaurant($updatedRestaurant);
      header('Location: index.php?controller=restaurant&action=index');
    } else {
      include 'views/restaurant/edit.php';
    }
  }

  public function delete() {
    $id = $_GET['id'];
    $this->restaurantsModel->deleteRestaurant($id);
    header('Location: index.php?controller=restaurant&action=index');
  }

  private function parseCarte($carteString) {
    $carte = [];
    foreach (explode(';', $carteString) as $plat) {
      list($id, $nom, $type, $prix, $description) = explode(',', $plat);
      $carte[] = [
        'id' => trim($id),
        'nom' => trim($nom),
        'type' => trim($type),
        'prix' => trim($prix),
        'description' => trim($description)
      ];
    }
    return $carte;
  }

  private function parseMenus($menusString) {
    $menus = [];
    foreach (explode(';', $menusString) as $menu) {
      list($titre, $description, $prix, $items) = explode(',', $menu);
      $menus[] = [
        'titre' => trim($titre),
        'description' => trim($description),
        'prix' => trim($prix),
        'items' => explode('|', trim($items))
      ];
    }
    return $menus;
  }
}
