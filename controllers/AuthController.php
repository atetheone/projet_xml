<?php

class AuthController {
  public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = $_POST['username'];
      $password = $_POST['password'];

      if ($this->authenticate($username, $password)) {
        header('Location: index.php');
        exit();
      } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
        include 'views/auth/login.php';
      }
    } else {
        include 'views/auth/login.php';
    }
  }

  public function logout() {
    session_destroy();
    header('Location: index.php');
  }

  private function authenticate($username, $password) {
    $users = require 'config/users.php';
    foreach ($users as $user) {
      if ($user['username'] === $username && $user['password'] === $password) { // Utiliser password_verify pour vérifier les mots de passe hachés
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        return true;
      }
    }
    return false;
  }

  public static function checkAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
  }

  public static function checkLoggedIn() {
    return isset($_SESSION['username']);
  }
}
