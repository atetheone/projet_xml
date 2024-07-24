<?php include 'views/includes/header.php'; ?>

<h1 class="title">Ajouter un Restaurant</h1>

<form action="index.php?controller=restaurant&action=add" method="POST">
  <label>Nom:</label>
  <input type="text" name="nom" required>

  <label>Adresse:</label>
  <input type="text" name="adresse" required>

  <label>Restaurateur:</label>
  <input type="text" name="restaurateur" required>

  <h2>Description:</h2>
  <div id="description">
    <div class="description-item">
      <select name="description[0][type]" required>
        <option value="texte">Texte</option>
        <option value="image">Image</option>
        <option value="liste">Liste</option>
        <option value="important">Important</option>
      </select>
      <textarea name="description[0][content]" placeholder="Contenu" required></textarea>
      <button class="btn btn-2" type="button" onclick="removeDescriptionItem(this)">Supprimer</button>
    </div>
  </div>
  <button class="btn btn-2" type="button" onclick="addDescriptionItem()">Ajouter un élément de description</button>
    
    <h2>Éléments de Description Ajoutés</h2>
    <div id="descriptionList">
        <!-- Les éléments de description ajoutés seront affichés ici -->
    </div>

    <h2>Carte</h2>
    <?php include 'views/includes/plats.php'; ?>


    <h2>Menus</h2>
    <?php include 'views/includes/menus.php'; ?>
    

    <input type="submit" value="Ajouter">
</form>

<?php include 'views/includes/footer.php'; ?>

<script>
    let descriptionCount = 0;
    let platCount = 0;
    let menuCount = 0;
    let plats = [];
    let menus = [];
    let editingPlatIndex = -1;
    let editingMenuIndex = -1;
</script>
<script src="public/js/restaurants.js"></script>