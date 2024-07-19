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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $restaurant = $this->createRestaurantFromPostData();
      $this->restaurantsModel->addRestaurant($restaurant);
      header('Location: index.php?controller=restaurant&action=index');
    } else {
      include 'views/restaurant/add.php';
    }
  }

  public function edit() {
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

  /*public function add() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $coordonnees = new Coordonnees(
        $_POST['nom'],
        $_POST['adresse'],
        $_POST['restaurateur'],
        $this->parseDescription($_POST['description'])
      );

      $carte = new Carte();
      foreach ($_POST['carte'] as $platData) {
        $carte->addPlat(new Plat(
          'p' . uniqid(),
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
          if (isset($menuData['elements'])) {
            foreach ($menuData['elements'] as $element) {
              $elements[] = $carte->getPlatById($element);
            }
          }
          $menus[] = new Menu(
            $menuData['titre'],
            $menuData['description'],
            $menuData['prix'],
            $elements
          );
        }
      }

      $restaurant = new Restaurant('r' . uniqid(), $coordonnees, $carte, $menus);
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
      $coordonnees = new Coordonnees(
        $_POST['nom'],
        $_POST['adresse'],
        $_POST['restaurateur'],
        $this->parseDescription($_POST['description'])
    );

    $carte = new Carte();
    foreach ($_POST['carte'] as $platData) {
      $carte->addPlat(new Plat(
          uniqid(),
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
        if (isset($menuData['elements'])) {
          foreach ($menuData['elements'] as $element) {
            $elements[] = $carte->getPlatById($element);
          }
        }
        $menus[] = new Menu(
          $menuData['titre'],
          $menuData['description'],
          $menuData['prix'],
          $elements
        );
      }
    }

    $restaurant = new Restaurant($id, $coordonnees, $carte, $menus);
      $this->restaurantsModel->updateRestaurant($updatedRestaurant);
      header('Location: index.php?controller=restaurant&action=index');
    } else {
      include 'views/restaurant/edit.php';
    }
  }*/

  public function delete() {
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
      $carte->addPlat(new Plat(
        'p' . uniqid(),
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
        if (isset($menuData['elements'])) {
          foreach ($menuData['elements'] as $element) {
            $elements[] = $carte->getPlatById($element);
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

/*

  private function parseDescription($descriptionString) {
    $description = new Description();
    $elements = explode(';', $descriptionString);
    foreach ($elements as $element) {
      list($type, $content) = explode(':', $element, 2);
      switch ($type) {
        case 'paragraphe':
          $description->addParagraphe(trim($content));
          break;
        case 'image':
          list($url, $position) = explode(',', $content);
          $description->addParagraphe(new Image(trim($url), trim($position)));
          break;
        case 'liste':
          $items = array_map('trim', explode(',', $content));
          $description->addParagraphe(new Liste($items));
          break;
        case 'important':
          $description->addParagraphe(new Important(trim($content)));
          break;
      }
    }
    return $description;
  }*/
}
