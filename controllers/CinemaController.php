<?php
require 'models/Cinema.php';
require 'models/Film.php';

class CinemaController {
  private $cinema;

  public function __construct() {
    $this->cinema = new Cinema("xml/cinema.xml");
  }

  public function index() {
    $films = $this->cinema->getAllFilms();
    include 'views/film/index.php';
  }

  public function show() {
    $id = $_GET['id'];
    $film = $this->cinema->getFilmById($id);
    include 'views/film/show.php';
  }

  public function add() {
    $this->adminVerify();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->saveFilm('add');
    } else {
        include 'views/film/add.php';
    }
  }

  public function edit() {
    $this->adminVerify();

    $id = $_GET['id'];
    $film = $this->cinema->getFilmById($id);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->saveFilm('edit', $id);
    } else {
      include 'views/film/edit.php';
    }
  }

  public function delete() {
    $this->adminVerify();

    $id = $_GET['id'];
    $this->cinema->deleteFilm($id);
    header('Location: index.php?controller=film&action=index');
  }

  private function parseNotes($notesString) {
    $notes = [];
    foreach (explode(';', $notesString) as $note) {
      list($source, $text) = explode(':', $note);
      $notes[] = ['source' => trim($source), 'text' => trim($text)];
    }
    return $notes;
  }

  private function parseHoraires($horairesArray) {
    $horaires = [];

    foreach ($horairesArray as $horaire) {
      $jour = $horaire['jour'];
      $heure = $horaire['heure'];
      $minute = isset($horaire['minute']) ? $horaire['minute'] : '00';
      $horaires[] = [
        'jour' => trim($jour),
        'heure' => trim($heure),
        'minute' => trim($minute)
      ];
    }

    return $horaires;
  }

  private function saveFilm($action, $id = null) {
    $horairesArray = json_decode($_POST['horaires'], true);
    $film = new Film(
      $action === 'add' ? 'f' . uniqid() : $id,
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
      $this->parseHoraires($horairesArray)
    );

    if ($action === 'add') {
      $this->cinema->addFilm($film);
    } else {
      $this->cinema->updateFilm($film);
    }

    header('Location: index.php?controller=film&action=index');
  }

  private function adminVerify() {
    if (!AuthController::checkAdmin()) {
      header('Location: index.php?controller=auth&action=login');
      exit();
    }
  }
}
