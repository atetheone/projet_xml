<?php include 'views/includes/header.php'; ?>

<h1 class="title">Modifier le Restaurant</h1>
<form action="index.php?controller=restaurant&action=edit&id=<?= $restaurant->id; ?>" method="POST">
  <label>Nom:</label>
  <input type="text" name="nom" value="<?= $restaurant->coordonnees->nom; ?>" readonly>
  
  <label>Adresse:</label>
  <input type="text" name="adresse" value="<?= $restaurant->coordonnees->adresse; ?>" required>
  
  <label>Restaurateur:</label>
  <input type="text" name="restaurateur" value="<?= $restaurant->coordonnees->restaurateur; ?>" required>
    
  <h2>Description</h2>
  <?php include 'views/includes/description.php'; ?>
  <button class="btn btn-2" type="button" onclick="addDescriptionItem()">Ajouter un élément de description</button>

  <h2>Carte</h2>
  <?php include 'views/includes/plats.php'; ?>

  <h2>Menus</h2>
  <?php include 'views/includes/menus.php'; ?>

  
  <button class="btn" type="submit">Modifier le Restaurant</button>
</form>

<?php include 'views/includes/footer.php'; ?>


<script>
  let descriptionCount = <?= count($restaurant->coordonnees->description->paragraphes); ?>;
  let platCount = <?= count($restaurant->carte->plats); ?>;
  let menuCount = <?= count($restaurant->menus); ?>;
  let plats = <?= json_encode($restaurant->carte->plats); ?>;
  let menus = <?= json_encode($restaurant->menus); ?>;
  let editingPlatIndex = -1;
  let editingMenuIndex = -1;
</script>

<script src="public/js/restaurants.js"></script>


