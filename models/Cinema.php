<?php

class Cinema {
  private $xmlRoot;

  public function __construct($xmlFile) {
    $this->xmlFile = $xmlFile;
    $this->xmlRoot = $this->loadFilmsXML();
  }

   public function getAllFilms() {
    $films = [];
    foreach ($this->xmlRoot->film as $film) {
      $films[] = $this->createFilmFromXML($film);
    }
    return $films;
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

  public function deleteFilm($id) {
    $dom = dom_import_simplexml($this->xmlRoot);
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
