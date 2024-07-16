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

  // public function updateFilm($film) {
  //   foreach (this->films->film as $filmElement) {
  //     if ($filmElement['id'] == $film->id) {
  //       $filmElement->titre = $film->titre;
  //       $filmElement->durée['heures'] = $film->dureeHeures;
  //       $filmElement->durée['minutes'] = $film->dureeMinutes;
  //       $filmElement->genres = null;
  //       $genres = $filmElement->addChild('genres');
  //       foreach ($film->genres as $genre) {
  //           $genres->addChild('genre', $genre);
  //       }
  //       $filmElement->réalisateur = $film->realisateur;
  //       $filmElement->langue = $film->langue;
  //       $filmElement->acteurs = null;
  //       $acteurs = $filmElement->addChild('acteurs');
  //       foreach ($film->acteurs as $acteur) {
  //           $acteurs->addChild('acteur', $acteur);
  //       }
  //       $filmElement->année = $film->annee;
  //       $filmElement->notes = null;
  //       if (!empty($film->notes)) {
  //           $notes = $filmElement->addChild('notes');
  //           foreach ($film->notes as $note) {
  //               $noteElement = $notes->addChild('note', $note['note']);
  //               $noteElement->addAttribute('source', $note['source']);
  //           }
  //       }
  //       $filmElement->synopsis = $film->synopsis;
  //       $filmElement->horaires = null;
  //       $horaires = $filmElement->addChild('horaires');
  //       foreach ($film->horaires as $horaire) {
  //         $horaireElement = $horaires->addChild('horaire');
  //         $horaireElement->addAttribute('jour', $horaire['jour']);
  //         $horaireElement->addAttribute('heure', $horaire['heure']);
  //         $horaireElement->addAttribute('minute', $horaire['minute']);
  //       }

  //       $this->saveXML();
  //       return;
  //     }
  //   }
  // } 

  private function loadFilmsXML() {
    if (file_exists($this->xmlFile)) {
      return simplexml_load_file($this->xmlFile);
    } else {
      throw new Exception('Échec lors de l\'ouverture du fichier ' . $this->xmlFile);
    }
  }

  private function createFilmFromXML($film) {
    $genres = [];
    foreach ($film->genres->genre as $genre) {
      $genres[] = (string) $genre;
    }

    $acteurs = [];
    foreach ($film->acteurs->acteur as $acteur) {
      $acteurs[] = (string) $acteur;
    }

    $notes = [];
    foreach ($film->notes->note as $note) {
      $notes[] = ['source' => (string) $note['source'], 'text' => (string) $note];
    }

    $horaires = [];
    foreach ($film->horaires->horaire as $horaire) {
      $horaires[] = [
        'jour' => (string) $horaire['jour'],
        'heure' => (string) $horaire['heure'],
        'minute' => (string) $horaire['minute']
      ];
    }

    return new Film(
      (string) $film['id'],
      (string) $film->titre,
      (string) $film->duree['heures'],
      (string) $film->duree['minutes'],
      $genres,
      (string) $film->realisateur,
      (string) $film->langue,
      $acteurs,
      (string) $film->annee,
      $notes,
      (string) $film->synopsis,
      $horaires
    );
  }

  private function fillXMLFromFilm($filmXML, $film) {
    $filmXML['id'] = $film->id;
    $filmXML->titre = $film->titre;

    $filmXML->duree['heures'] = $film->duree_heures;
    $filmXML->duree['minutes'] = $film->duree_minutes;

    $filmXML->genres = '';
    foreach ($film->genres as $genre) {
        $filmXML->genres->addChild('genre', $genre);
    }

    $filmXML->realisateur = $film->realisateur;
    $filmXML->langue = $film->langue;

    $filmXML->acteurs = '';
    foreach ($film->acteurs as $acteur) {
        $filmXML->acteurs->addChild('acteur', $acteur);
    }

    $filmXML->annee = $film->annee;

    $filmXML->notes = '';
    foreach ($film->notes as $note) {
        $noteXML = $filmXML->notes->addChild('note', $note['text']);
        $noteXML->addAttribute('source', $note['source']);
    }

    $filmXML->synopsis = $film->synopsis;

    $filmXML->horaires = '';
    foreach ($film->horaires as $horaire) {
      $horaireXML = $filmXML->horaires->addChild('horaire');
      $horaireXML->addAttribute('jour', $horaire['jour']);
      $horaireXML->addAttribute('heure', $horaire['heure']);
      $horaireXML->addAttribute('minute', $horaire['minute']);
    }
  }

  private function saveXML() {
    $this->xmlRoot->asXML($this->xmlFile);
  }
}
