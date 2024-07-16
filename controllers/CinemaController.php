<?php
require 'models/Cinema.php';
require 'models/Film.php';

class FilmController {
  private $cinema;

  public function __construct() {
    $this->cinema = new Cinema("xml/cinema.xml");
  }

  public function index() {
    $films = $this->cinema->getAllFilms();
    include 'views/film/index.php';
  }

  public function add() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $film = new Film(
        uniqid(),
        $_POST['titre'],
        $_POST['duree_heures'],
        $_POST['duree_minutes'],
        explode(',', $_POST['genres']),
        $_POST['realisateur'],
        $_POST['langue'],
        explode(',', $_POST['acteurs']),
        $_POST['annee'],
        $this->parseNotes($_POST['notes']),
        $_POST['synopsis'],
        $this->parseHoraires($_POST['horaires'])
      );
      $this->cinema->addFilm($film);
      header('Location: index.php?controller=film&action=index');
    } else {
        include 'views/film/add.php';
    }
  }

  public function edit() {
    $id = $_GET['id'];
    $film = $this->cinema->getFilmById($id);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $updatedFilm = new Film(
        $id,
        $_POST['titre'],
        $_POST['duree_heures'],
        $_POST['duree_minutes'],
        explode(',', $_POST['genres']),
        $_POST['realisateur'],
        $_POST['langue'],
        explode(',', $_POST['acteurs']),
        $_POST['annee'],
        $this->parseNotes($_POST['notes']),
        $_POST['synopsis'],
        $this->parseHoraires($_POST['horaires'])
      );
      $this->cinema->updateFilm($updatedFilm);
      header('Location: index.php?controller=film&action=index');
    } else {
      include 'views/film/edit.php';
    }
  }

  public function delete() {
    $id = $_GET['id'];
    $this->cinema->deleteFilm($id);
    header('Location: index.php?controller=film&action=index');
  }
}
