<?php

class RestaurantsModel {
  private $xmlRoot;
  private $xmlFile;

  public function __construct($xmlFile) {
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
    $dom = dom_import_simplexml($this->xmlRoot);
    foreach ($dom->getElementsByTagName('restaurant') as $restaurant) {
      if ($restaurant->getAttribute('id') == $id) {
        $restaurant->parentNode->removeChild($restaurant);
        $this->saveXML();
        return;
      }
    }
  }

  private function parseDescription($xmlDescription) {
    $description = new Description();
    foreach ($xmlDescription->children() as $child) {
      if ($child->getName() == 'image') {
          $description->addParagraphe(new Image((string)$child['url'], (string)$child['position']));
      } elseif ($child->getName() == 'liste') {
          $items = [];
          foreach ($child->item as $item) {
              $items[] = (string)$item;
          }
          $description->addParagraphe(new Liste($items));
      } elseif ($child->getName() == 'important') {
          $description->addParagraphe(new Important((string)$child));
      } else {
          $description->addParagraphe((string)$child);
      }
    }
    return $description;
  }


  private function createRestaurantFromXML($xmlRestaurant) {
    $coordonnees = new Coordonnees(
      (string)$xmlRestaurant->coordonnees->nom,
      (string)$xmlRestaurant->coordonnees->adresse,
      (string)$xmlRestaurant->coordonnees->restaurateur,
      $this->parseDescription($xmlRestaurant->coordonnees->description)
    );

    $carte = new Carte();
    foreach ($xmlRestaurant->carte->plat as $xmlPlat) {
      $carte->addPlat(new Plat(
        (string)$xmlPlat['id'],
        (string)$xmlPlat->nom,
        (string)$xmlPlat->type,
        (string)$xmlPlat->prix,
        (string)$xmlPlat->prix['devise'],
        (string)$xmlPlat->platDescription
      ));
    }

    $menus = [];
    if (isset($xmlRestaurant->menus)) {
      foreach ($xmlRestaurant->menus->menu as $xmlMenu) {
        $elements = [];
        foreach ($xmlMenu->element as $element) {
          $elements[] = $carte->getPlatById((string)$element['plat']);
        }
        $menus[] = new Menu(
          (string)$xmlMenu->titre,
          (string)$xmlMenu->menuDescription,
          (string)$xmlMenu->prix,
          (string)$xmlMenu->prix['devise'],
          $elements
        );
      }
    }

    return new Restaurant((string)$xmlRestaurant['id'], $coordonnees, $carte, $menus);
  }

  private function fillXMLFromRestaurant($restaurantXML, $restaurant) {
    $xmlCoordonnees = $restaurantXML->addChild('coordonnees');
    $xmlCoordonnees->addChild('nom', $restaurant->coordonnees->nom);
    $xmlCoordonnees->addChild('adresse', $restaurant->coordonnees->adresse);
    $xmlCoordonnees->addChild('restaurateur', $restaurant->coordonnees->restaurateur);
    $xmlCoordonnees->addChild('description', $this->serializeDescription($restaurant->coordonnees->description));

    $xmlCarte = $restaurantXML->addChild('carte');
    foreach ($restaurant->carte->plats as $plat) {
        $xmlPlat = $xmlCarte->addChild('plat');
        $xmlPlat->addAttribute('id', $plat->id);
        $xmlPlat->addChild('nom', $plat->nom);
        $xmlPlat->addChild('type', $plat->type);
        $xmlPlat->addChild('prix', $plat->prix);
        $xmlPlat->prix->addAttribute('devise', $plat->devise);
        $xmlPlat->addChild('platDescription', $plat->description);
    }

    if (!empty($restaurant->menus)) {
      $xmlMenus = $restaurantXML->addChild('menus');
      foreach ($restaurant->menus as $menu) {
        $xmlMenu = $xmlMenus->addChild('menu');
        $xmlMenu->addChild('titre', $menu->titre);
        $xmlMenu->addChild('menuDescription', $menu->description);
        $xmlMenu->addChild('prix', $menu->prix);
        $xmlMenu->prix->addAttribute('devise', $menu->devise);
      
        foreach ($menu->elements as $element) {
          $xmlElement = $xmlMenu->addChild('element');
          $xmlElement->addAttribute('plat', $element->id);
        }
      }
    }
  } 

  private function loadRestaurantsXML() {
    if (file_exists($this->xmlFile)) {
      return simplexml_load_file($this->xmlFile);
    } else {
      throw new Exception('Échec lors de l\'ouverture du fichier ' . $this->xmlFile);
    }
  }

  private function saveXML() {
    $this->xmlRoot->asXML($this->xmlFile);
  }

  private function parseCarte($carteXML) {
    $carte = [];
    foreach ($carteXML->plat as $plat) {
      $carte[] = [
        'id' => (string) $plat['id'],
        'nom' => (string) $plat->nom,
        'type' => (string) $plat->type,
        'prix' => (string) $plat->prix,
        'description' => (string) $plat->platDescription
      ];
    }
    return $carte;
  }

  private function serializeDescription($description) {
    $xml = '';
    foreach ($description->paragraphes as $paragraphe) {
      if ($paragraphe instanceof Image) {
        $xml .= '<image url="' . $paragraphe->url . '" position="' . $paragraphe->position . '"/>';
      } elseif ($paragraphe instanceof Liste) {
        $xml .= '<liste>';
        foreach ($paragraphe->items as $item) {
          $xml .= '<item>' . $item . '</item>';
        }
        $xml .= '</liste>';
      } elseif ($paragraphe instanceof Important) {
        $xml .= '<important>' . $paragraphe->texte . '</important>';
      } else {
        $xml .= '<paragraphe>' . $paragraphe . '</paragraphe>';
      }
    }
    return $xml;
  }
}
