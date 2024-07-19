<?php include 'views/includes/header.php'; ?>

<h1 class="title">Ajouter un Restaurant</h1>

<form action="index.php?controller=restaurant&action=add" method="POST">
    <label>Nom:</label>
    <input type="text" name="nom" required>

    <label>Adresse:</label>
    <input type="text" name="adresse" required>

    <label>Restaurateur:</label>
    <input type="text" name="restaurateur" required>

    <label>Description:</label>
    <textarea name="description" required></textarea>

    <h2>Carte</h2>
    <div id="plats">
      <div class="plat">
        <label>Nom du plat:</label>
        <input type="text" name="carte[0][nom]">
        
        <label>Type:</label>
        <input type="text" name="carte[0][type]">
        
        <label>Prix:</label>
        <input type="text" name="carte[0][prix]">
        
        <label>Devise:</label>
        <input type="text" name="carte[0][devise]">
        
        <label>Description:</label>
        <textarea name="carte[0][description]"></textarea>
        <button class="btn" type="button" onclick="addPlat()">Ajouter un plat</button>
      </div>
    </div>
    <h2>Plats Ajoutés</h2>
    <table id="platsTable">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Type</th>
          <th>Prix</th>
          <th>Devise</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Les plats ajoutés seront affichés ici -->
      </tbody>
    </table>


    <h2>Menus</h2>
    <div id="menus">
      <div class="menu">
        <label>Titre du menu:</label>
        <input type="text" name="menus[0][titre]">
        
        <label>Description:</label>
        <textarea name="menus[0][description]"></textarea>
        
        <label>Prix:</label>
        <input type="text" name="menus[0][prix]">
        
        <label>Éléments:</label>
        <select name="menus[0][elements][]" multiple>
            <!-- Les options seront remplies dynamiquement avec les plats ajoutés -->
        </select>
        <button type="button" onclick="addElementToMenu(0)">Ajouter un élément</button>

      </div>
      <button class="btn" type="button" onclick="addMenu()">Ajouter un menu</button>

      <h2>Menus Ajoutés</h2>
      <table id="menusTable">
        <thead>
          <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Éléments</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Les menus ajoutés seront affichés ici -->
        </tbody>
      </table>
    </div>

    <input type="submit" value="Ajouter">
</form>

<?php include 'views/includes/footer.php'; ?>

<script src="public/js/restaurants.js"></script>