<?php

class Restaurant {
  public $id;
  public $nom;
  public $adresse;
  public $restaurateur;
  public $description;
  public $carte;
  public $menus;

  public function __construct($id, $nom, $adresse, $restaurateur, $description, $carte, $menus) {
    $this->id = $id;
    $this->nom = $nom;
    $this->adresse = $adresse;
    $this->restaurateur = $restaurateur;
    $this->description = $description;
    $this->carte = $carte;
    $this->menus = $menus;
  }
}
