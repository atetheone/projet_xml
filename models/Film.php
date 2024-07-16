<?php

class Film {
  public $id;
  public $titre;
  public $duree_heures;
  public $duree_minutes;
  public $genres = [];
  public $realisateur;
  public $langue;
  public $acteurs = [];
  public $annee;
  public $notes = [];
  public $synopsis;
  public $horaires = [];

  public function __construct($id, $titre, $duree_heures, $duree_minutes, $genres, $realisateur, $langue, $acteurs, $annee, $notes, $synopsis, $horaires) {
    $this->id = $id;
    $this->titre = $titre;
    $this->duree_heures = $duree_heures;
    $this->duree_minutes = $duree_minutes;
    $this->genres = $genres;
    $this->realisateur = $realisateur;
    $this->langue = $langue;
    $this->acteurs = $acteurs;
    $this->annee = $annee;
    $this->notes = $notes;
    $this->synopsis = $synopsis;
    $this->horaires = $horaires;
  }
}
  