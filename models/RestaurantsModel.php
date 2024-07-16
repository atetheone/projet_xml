<?php

class RestaurantsModel {
  private $xmlRoot;
  private $xmlFile;

  public function __construct(xmlFile) {
    $this->xmlFile = $xmlFile;
    $this->xmlRoot = $this->loadRestaurantsXML();
  }

  public function getAllRestaurants() {
    $restaurants = [];
    foreach ($this->xmlRoot->restaurant as $restaurant) {
        $restaurants[] = $this->createRestaurantFromXML($restaurant);
    }
    return $restaurants;
  }

  public function getRestaurantById($id) {
    foreach ($this->xmlRoot->restaurant as $restaurant) {
      if ((string) $restaurant['id'] == $id) {
        return $this->createRestaurantFromXML($restaurant);
      }
    }
    return null;
  }

  public function addRestaurant($restaurant) {
    $newRestaurant = $this->xmlRoot->addChild('restaurant');
    $newRestaurant->addAttribute('id', $restaurant->id);
    $this->fillXMLFromRestaurant($newRestaurant, $restaurant);
    $this->saveXML();
  }

  public function updateRestaurant($restaurant) {
    foreach ($this->xmlRoot->restaurant as $restaurantXML) {
      if ((string) $restaurantXML['id'] == $restaurant->id) {
        $this->fillXMLFromRestaurant($restaurantXML, $restaurant);
        $this->saveXML();
        return;
      }
    }
  }

  public function deleteRestaurant($id) {
    $dom = dom_import_simplexml($this->xml);
    foreach ($dom->getElementsByTagName('restaurant') as $restaurant) {
      if ($restaurant->getAttribute('id') == $id) {
        $restaurant->parentNode->removeChild($restaurant);
        $this->saveXML();
        return;
      }
    }
  }

  private function createRestaurantFromXML($restaurant) {
    $id = (string) $restaurant['id'];
    $coordonnees = $restaurant->coordonnees;
    $nom = (string) $coordonnees->nom;
    $adresse = (string) $coordonnees->adresse;
    $restaurateur = (string) $coordonnees->restaurateur;
    $description = $this->parseDescription($coordonnees->description);

    $carte = [];
    foreach ($restaurant->carte->plat as $plat) {
      $carte[] = [
        'id' => (string) $plat['id'],
        'nom' => (string) $plat->nom,
        'type' => (string) $plat->type,
        'prix' => (string) $plat->prix,
        'description' => (string) $plat->platDescription
      ];
    }

    $menus = [];
    if ($restaurant->menus) {
      foreach ($restaurant->menus->menu as $menu) {
        $menuItems = [];
        foreach ($menu->element as $element) {
          $menuItems[] = (string) $element['plat'];
        }
        $menus[] = [
          'titre' => (string) $menu->titre,
          'description' => (string) $menu->menuDescription,
          'prix' => (string) $menu->prix,
          'items' => $menuItems
        ];
      }
    }

    return new Restaurant($id, $nom, $adresse, $restaurateur, $description, $carte, $menus);
  }

  private function fillXMLFromRestaurant($restaurantXML, $restaurant) {
    $coordonnees = $restaurantXML->addChild('coordonnees');
    $coordonnees->addChild('nom', $restaurant->nom);
    $coordonnees->addChild('adresse', $restaurant->adresse);
    $coordonnees->addChild('restaurateur', $restaurant->restaurateur);
    $this->fillDescriptionXML($coordonnees->addChild('description'), $restaurant->description);

    $carteXML = $restaurantXML->addChild('carte');
    foreach ($restaurant->carte as $plat) {
      $platXML = $carteXML->addChild('plat');
      $platXML->addAttribute('id', $plat['id']);
      $platXML->addChild('nom', $plat['nom']);
      $platXML->addChild('type', $plat['type']);
      $platXML->addChild('prix', $plat['prix'])->addAttribute('devise', 'EUR');
      $platXML->addChild('platDescription', $plat['description']);
    }

    if ($restaurant->menus) {
      $menusXML = $restaurantXML->addChild('menus');
      foreach ($restaurant->menus as $menu) {
        $menuXML = $menusXML->addChild('menu');
        $menuXML->addChild('titre', $menu['titre']);
        $menuXML->addChild('menuDescription', $menu['description']);
        $menuXML->addChild('prix', $menu['prix']);
        foreach ($menu['items'] as $item) {
          $menuXML->addChild('element')->addAttribute('plat', $item);
        }
      }
    }
  }

  private function parseDescription($descriptionXML) {
    // Fonction pour parser la description en un format plus utilisable
    // ...
    return (string) $descriptionXML;
  }

  private function fillDescriptionXML($descriptionXML, $description) {
    // Fonction pour remplir la description XML à partir d'un format plus utilisable
    // ...
  }

  private function loadRestaurantsXML() {
    if (file_exists($this->xmlFile)) {
      return simplexml_load_file($this->xmlFile);
    } else {
      throw new Exception('Échec lors de l\'ouverture du fichier ' . $this->xmlFile);
    }
  }

  private function saveXML() {
    $this->xml->asXML($this->xmlFile);
  }
}
