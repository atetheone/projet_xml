<?php

class Cinema {
  private $xmlFile;
  private $xmlRoot;
  private $films = [];

  public function __construct($xmlFile) {
    $this->xmlFile = $xmlFile;
    $this->xmlRoot = $this->loadFilmsXML();
  }

  public function getAllFilms() {
    $films = [];
    foreach ($this->xml->film as $film) {
      $films[] = $this->createFilmFromXML($film);
    }
    return $films;
  }

  public function getFilms() {
    foreach ($this->xmlRoot->film as $film) {
      $this->films[] = new Film($filmElement);
    }
    return $this->films;
  }

  public function getFilmById($filmId) {
      foreach ($this->films as $film) {
        if ($film['id'] == $filmId) {
          return $film;
        }
      }
      return null;
  }

  public function addFilm($film) {
    $newFilm = $this->xmlRoot->addChild('film');
    $this->fillXMLFromFilm($newFilm, $film);
    $this->saveXML();
  }

  public function deleteFilm($filmId) {
    foreach ($this->xmlRoot->film as $film) {
      if ($film['id'] == $filmId) {
        $dom = dom_import_simplexml($film);
        foreach ($dom->getElementsByTagName('film') as $film) {
      if ($film->getAttribute('id') == $id) {
        $film->parentNode->removeChild($film);
        $this->saveXML();
        return;
      }
    }
  }

  public function updateFilm($film) {
    foreach ($this->xml->film as $filmXML) {
      if ((string) $filmXML['id'] == $film->id) {
        $this->fillXMLFromFilm($filmXML, $film);
        $this->saveXML();
        return;
      }
    }
  } 

  private function saveXML() {
    $this->xmlRoot->asXML($this->xmlFile);
  }
}
