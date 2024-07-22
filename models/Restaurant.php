<?php

class Restaurant {
  public $id;
  public $coordonnees;
  public $carte;
  public $menus;
  public $menusOrdre;

  public function __construct($id, $coordonnees, $carte, $menus = [], $ordre = 'apparition') {
      $this->id = $id;
      $this->coordonnees = $coordonnees;
      $this->carte = $carte;
      $this->menus = $menus;
      $this->menusOrdre = $ordre;
  }
}

class Coordonnees {
  public $nom;
  public $adresse;
  public $restaurateur;
  public $description;

  public function __construct($nom, $adresse, $restaurateur, $description) {
      $this->nom = $nom;
      $this->adresse = $adresse;
      $this->restaurateur = $restaurateur;
      $this->description = $description;
  }
}

class Description {
  public $paragraphes = [];

  public function addParagraphe($paragraphe) {
    $this->paragraphes[] = $paragraphe;
  }
}

class Paragraphe {
  public $content = [];

  public function addContent($item) {
    $this->content[] = $item;
  }
}

class Texte {
  public $texte;

  public function __construct($texte) {
    $this->texte = $texte;
  }
}

class Image {
  public $url;
  public $position;

  public function __construct($url, $position) {
      $this->url = $url;
      $this->position = $position;
  }
}

class Liste {
  public $items = [];

  public function __construct($items) {
      $this->items = $items;
  }
}

class Important {
  public $texte;

  public function __construct($texte) {
      $this->texte = $texte;
  }
}

class Plat {
  public $id;
  public $nom;
  public $type;
  public $prix;
  public $devise;
  public $description;

  public function __construct($id, $nom, $type, $prix, $devise, $description) {
      $this->id = $id;
      $this->nom = $nom;
      $this->type = $type;
      $this->prix = $prix;
      $this->devise = $devise;
      $this->description = $description;
  }
}

class Menu {
  public $titre;
  public $description;
  public $prix;
  public $devise;
  public $elements = [];

  public function __construct($titre, $description, $prix, $devise, $elements = []) {
    $this->titre = $titre;
    $this->description = $description;
    $this->prix = $prix;
    $this->devise = $devise;
    $this->elements = $elements;
  }
}

class Carte {
  public $plats = [];

  public function addPlat($plat) {
      $this->plats[] = $plat;
  }

  public function getPlatById($id) {
    foreach ($this->plats as $plat) {
      if ($plat->id === $id) {
        return $plat;
      }
    }
    return null;
  }
}
