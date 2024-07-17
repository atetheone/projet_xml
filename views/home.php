<?php include 'views/includes/header.php'; ?>

<h1 class="title">Bienvenue sur notre site</h1>

<?php if (AuthController::checkLoggedIn() && AuthController::checkAdmin()): ?>
  <p>Bonjour, <?php echo $_SESSION['username']; ?>!</p>
  <p>Rôle : Administrateur</p>

  <div class="admin-links">
    <a href="index.php?controller=film&action=index" class="btn">Gérer les Films</a>
    <a href="index.php?controller=restaurant&action=index" class="btn">Gérer les Restaurants</a>
  </div>

<?php else: ?>
  <div class="viewer-links">
    <a href="index.php?controller=film&action=index" class="btn">Voir les Films</a>
    <a href="index.php?controller=restaurant&action=index" class="btn">Voir les Restaurants</a>
  </div>
<?php endif; ?>

<?php include 'views/includes/footer.php'; ?>
