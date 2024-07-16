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
        $dom->parentNode->removeChild($dom);
        $this->saveXML();
        return;
      }
    }
  }

  public function updateFilm($film) {
    foreach (this->films->film as $filmElement) {
      if ($filmElement['id'] == $film->id) {
        $filmElement->titre = $film->titre;
        $filmElement->durée['heures'] = $film->dureeHeures;
        $filmElement->durée['minutes'] = $film->dureeMinutes;
        $filmElement->genres = null;
        $genres = $filmElement->addChild('genres');
        foreach ($film->genres as $genre) {
            $genres->addChild('genre', $genre);
        }
        $filmElement->réalisateur = $film->realisateur;
        $filmElement->langue = $film->langue;
        $filmElement->acteurs = null;
        $acteurs = $filmElement->addChild('acteurs');
        foreach ($film->acteurs as $acteur) {
            $acteurs->addChild('acteur', $acteur);
        }
        $filmElement->année = $film->annee;
        $filmElement->notes = null;
        if (!empty($film->notes)) {
            $notes = $filmElement->addChild('notes');
            foreach ($film->notes as $note) {
                $noteElement = $notes->addChild('note', $note['note']);
                $noteElement->addAttribute('source', $note['source']);
            }
        }
        $filmElement->synopsis = $film->synopsis;
        $filmElement->horaires = null;
        $horaires = $filmElement->addChild('horaires');
        foreach ($film->horaires as $horaire) {
          $horaireElement = $horaires->addChild('horaire');
          $horaireElement->addAttribute('jour', $horaire['jour']);
          $horaireElement->addAttribute('heure', $horaire['heure']);
          $horaireElement->addAttribute('minute', $horaire['minute']);
        }

        $this->saveXML();
        return;
      }
    }
  } 

  private function saveXML() {
    $this->xmlRoot->asXML($this->xmlFile);
  }
}
