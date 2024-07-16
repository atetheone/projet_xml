<?php
require 'models/Cinema.php';
require 'models/Film.php';

class FilmController {
    private $cinema;

    public function __construct() {
      $this->cinema = new Cinema();
    }

    public function index() {
      $films = $this->cinema->getAllFilms();
      include 'views/film/index.php';
    }

    public function add() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $director = $_POST['director'];
        $year = $_POST['year'];
        $genre = $_POST['genre'];

        $film = new Film($title, $director, $year, $genre);
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
          $title = $_POST['title'];
          $director = $_POST['director'];
          $year = $_POST['year'];
          $genre = $_POST['genre'];
          $this->cinema->updateFilm($id, $title, $director, $year, $genre);
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
