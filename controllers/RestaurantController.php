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
    $this->adminVerify();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $restaurant = $this->createRestaurantFromPostData();
      $this->restaurantsModel->addRestaurant($restaurant);
      header('Location: index.php?controller=restaurant&action=index');
    } else {
      include 'views/restaurant/add.php';
    }
  }

  public function edit() {
    $this->adminVerify();

    $id = $_GET['id'];
    $restaurant = $this->restaurantsModel->getRestaurantById($id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updatedRestaurant = $this->createRestaurantFromPostData($id);
      $this->restaurantsModel->updateRestaurant($updatedRestaurant);
      header('Location: index.php?controller=restaurant&action=index');
    } else {
      include 'views/restaurant/edit.php';
    }
  }

  public function delete() {
    $this->adminVerify();

    $id = $_GET['id'];
    $this->restaurantsModel->deleteRestaurant($id);
    header('Location: index.php?controller=restaurant&action=index');
  }

  private function createRestaurantFromPostData($id = null) {
    $coordonnees = new Coordonnees(
      $_POST['nom'],
      $_POST['adresse'],
      $_POST['restaurateur'],
      $this->parseDescription($_POST['description'])
    );

    $carte = new Carte();
    foreach ($_POST['carte'] as $platData) {
      $platId = isset($platData['id']) ? $platData['id'] : 'p' . uniqid();
      $carte->addPlat(new Plat(
        $platId,
        $platData['nom'],
        $platData['type'],
        $platData['prix'],
        $platData['devise'],
        $platData['description']
      ));
    }

    $menus = [];
    if (!empty($_POST['menus'])) {
      foreach ($_POST['menus'] as $menuData) {
        $elements = [];
        var_dump($menuData['elements']);
        if (isset($menuData['elements'])) {
          foreach ($menuData['elements'] as $elementId) {
            $elements[] = $elementId;
          }
        }
        $menus[] = new Menu(
          $menuData['titre'],
          $menuData['description'],
          $menuData['prix'],
          $menuData['devise'] ?? 'FCFA',
          $elements
        );
      }
    }

    return new Restaurant($id ? $id : 'r' . uniqid(), $coordonnees, $carte, $menus);
  }

  private function parseDescription($descriptionData) {
    $description = new Description();
    if (!empty($descriptionData)) {
      foreach ($descriptionData as $paragrapheData) {
        $paragraphe = new Paragraphe();
        foreach ($paragrapheData as $item) {
          if (isset($item['type'])) {
            switch ($item['type']) {
              case 'texte':
                $paragraphe->addContent(new Texte($item['content']));
                break;
              case 'image':
                $contentParts = explode(', ', $item['content']);
                $url = str_replace('url:', '', $contentParts[0]);
                $position = str_replace('position:', '', $contentParts[1]);
                $paragraphe->addContent(new Image($url, $position));
                break;
              case 'liste':
                $items = explode(',', $item['content']);
                $paragraphe->addContent(new Liste(array_map('trim', $items)));
                break;
              case 'important':
                $paragraphe->addContent(new Important($item['content']));
                break;
              default:
                $paragraphe->addContent($item['content'] ?? $item);
                break;
            }
          } else {
            $paragraphe->addContent($item);
          }
        }
        $description->addParagraphe($paragraphe);
      }
    }
    return $description;
  }

  private function adminVerify() {
    if (!AuthController::checkAdmin()) {
      header('Location: index.php?controller=auth&action=login');
      exit();
    }
  }
}
