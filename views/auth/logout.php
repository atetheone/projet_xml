<?php

require 'controllers/AuthController.php';
AuthController::logout();
header('Location: index.php');

