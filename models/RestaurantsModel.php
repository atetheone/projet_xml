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
    foreach ($xmlDescription->paragraphe as $xmlParagraphe) {
      $paragraphe = new Paragraphe();
      foreach ($xmlParagraphe->children() as $child) {
        if ($child->getName() == 'texte') {
          $paragraphe->addContent(new Texte((string)$child));
        } elseif ($child->getName() == 'image') {
          $paragraphe->addContent(new Image((string)$child['url'], (string)$child['position']));
        } elseif ($child->getName() == 'liste') {
          $items = [];
          foreach ($child->item as $item) {
            $items[] = (string)$item;
          }
          $paragraphe->addContent(new Liste($items));
        } elseif ($child->getName() == 'important') {
          $paragraphe->addContent(new Important((string)$child));
        }
      }
      $description->addParagraphe($paragraphe);
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
    // Mise à jour des coordonnées
    if ($restaurantXML->coordonnees) {
      $restaurantXML->coordonnees->nom = $restaurant->coordonnees->nom;
      $restaurantXML->coordonnees->adresse = $restaurant->coordonnees->adresse;
      $restaurantXML->coordonnees->restaurateur = $restaurant->coordonnees->restaurateur;
      if (isset($restaurantXML->coordonnees->description)) {
        unset($restaurantXML->coordonnees->description);
      }
      $this->serializeDescription($restaurantXML->coordonnees->addChild('description'), $restaurant->coordonnees->description);
    } else {
      $xmlCoordonnees = $restaurantXML->addChild('coordonnees');
      $xmlCoordonnees->addChild('nom', $restaurant->coordonnees->nom);
      $xmlCoordonnees->addChild('adresse', $restaurant->coordonnees->adresse);
      $xmlCoordonnees->addChild('restaurateur', $restaurant->coordonnees->restaurateur);
      $this->serializeDescription($xmlCoordonnees->addChild('description'), $restaurant->coordonnees->description);
    }

    // Mise à jour de la carte
    if ($restaurantXML->carte) {
      unset($restaurantXML->carte);  // Supprimez la carte existante
    }
    $xmlCarte = $restaurantXML->addChild('carte');
    foreach ($restaurant->carte->plats as $plat) {
      $xmlPlat = $xmlCarte->addChild('plat');
      $xmlPlat->addAttribute('id', $plat->id);
      $xmlPlat->addChild('nom', $plat->nom);
      $xmlPlat->addChild('type', $plat->type);
      $xmlPrix = $xmlPlat->addChild('prix', $plat->prix);
      $xmlPrix->addAttribute('devise', (string)$plat->devise);
      $xmlPlat->addChild('platDescription', $plat->description);
    }

    // Mise à jour des menus
    if ($restaurantXML->menus) {
      unset($restaurantXML->menus);  // Supprimez les menus existants
    }
    if (!empty($restaurant->menus)) {
      $xmlMenus = $restaurantXML->addChild('menus');
      foreach ($restaurant->menus as $menu) {
        $xmlMenu = $xmlMenus->addChild('menu');
        $xmlMenu->addChild('titre', $menu->titre);
        $xmlMenu->addChild('menuDescription', $menu->description);
        $xmlPrix = $xmlMenu->addChild('prix', $menu->prix);
        $xmlPrix->addAttribute('devise', (string)$menu->devise);
        foreach ($menu->elements as $element) {
          $xmlElement = $xmlMenu->addChild('element');
          $xmlElement->addAttribute('plat', $element->id);
        }
      }
    }
  }
  
  private function loadRestaurantsXML() {
    if (!file_exists($this->xmlFile)) {
      throw new Exception('Échec lors de l\'ouverture du fichier ' . $this->xmlFile);
    }
  
    // Charger le document XML avec DOMDocument
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;

    // Charger le fichier XML
    $dom->load($this->xmlFile);

    // Activer la validation
    $dom->validateOnParse = true;

    // Valider le document XML contre la DTD
    if (!$dom->validate()) {
      throw new Exception('Le fichier XML n\'est pas valide selon la DTD');
    }

    return simplexml_load_file($this->xmlFile);
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

  private function serializeDescription($xmlDescription, $description) {
    foreach ($xmlDescription->children() as $child) {
      unset($child[0]); // Clear existing children
    }
    foreach ($description->paragraphes as $paragraphe) {
      $xmlParagraphe = $xmlDescription->addChild('paragraphe');
      foreach ($paragraphe->content as $item) {
        if ($item instanceof Texte) {
          $xmlParagraphe->addChild('texte', htmlspecialchars($item->texte));
        } elseif ($item instanceof Image) {
          $xmlImage = $xmlParagraphe->addChild('image');
          $xmlImage->addAttribute('url', htmlspecialchars($item->url));
          $xmlImage->addAttribute('position', htmlspecialchars($item->position));
        } elseif ($item instanceof Liste) {
          $xmlListe = $xmlParagraphe->addChild('liste');
          foreach ($item->items as $listItem) {
            $xmlListe->addChild('item', htmlspecialchars($listItem));
          }
        } elseif ($item instanceof Important) {
          $xmlParagraphe->addChild('important', htmlspecialchars($item->texte));
        }
      }
    }
  }
}
