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
  <div id="description">
    <?php foreach ($restaurant->coordonnees->description->paragraphes as $index => $paragraphe): ?>
      <?php foreach ($paragraphe->content as $contentIndex => $item): ?>
        <div class="description-item">
          <select name="description[<?= $index; ?>][<?= $contentIndex; ?>][type]" required>
            <option value="texte" <?= $item instanceof Texte ? 'selected' : ''; ?>>Texte</option>
            <option value="image" <?= $item instanceof Image ? 'selected' : ''; ?>>Image</option>
            <option value="liste" <?= $item instanceof Liste ? 'selected' : ''; ?>>Liste</option>
            <option value="important" <?= $item instanceof Important ? 'selected' : ''; ?>>Important</option>
          </select>
          <?php if ($item instanceof Texte): ?>
            <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required><?= htmlspecialchars($item->texte); ?></textarea>
          <?php elseif ($item instanceof Image): ?>
            <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required>url:<?= htmlspecialchars($item->url); ?>, position:<?= htmlspecialchars($item->position); ?></textarea>
          <?php elseif ($item instanceof Liste): ?>
            <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required><?= htmlspecialchars(implode(', ', $item->items)); ?></textarea>
          <?php elseif ($item instanceof Important): ?>
            <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required><?= htmlspecialchars($item->texte); ?></textarea>
          <?php endif; ?>
          <button class="btn btn-2" type="button" onclick="removeDescriptionItem(this)">Supprimer</button>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </div>
  <button class="btn btn-2" type="button" onclick="addDescriptionItem()">Ajouter un élément de description</button>

  <h2>Carte</h2>
  <div id="plats">
    <?php foreach ($restaurant->carte->plats as $index => $plat): ?>
      <div class="plat">
        <label>Nom du plat:</label>
        <input type="text" name="carte[<?= $index; ?>][nom]" value="<?= $plat->nom; ?>" required>
        
        <label>Type:</label>
        <input type="text" name="carte[<?= $index; ?>][type]" value="<?= $plat->type; ?>" required>
        
        <label>Prix:</label>
        <input type="text" name="carte[<?= $index; ?>][prix]" value="<?= $plat->prix; ?>" required>
        
        <label>Devise:</label>
        <input type="text" name="carte[<?= $index; ?>][devise]" value="<?= $plat->devise; ?>" required>
        
        <label>Description:</label>
        <textarea name="carte[<?= $index; ?>][description]" required><?= $plat->description; ?></textarea>
        <button class="btn btn-2" type="button" onclick="removePlat(this)">Supprimer</button>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="btn btn-2" type="button" onclick="addPlat()">Ajouter un plat</button>

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
    <?php foreach ($restaurant->menus as $index => $menu): ?>
      <div class="menu">
        <label>Titre du menu:</label>
        <input type="text" name="menus[<?= $index; ?>][titre]" value="<?= $menu->titre; ?>" required>
        
        <label>Description:</label>
        <textarea name="menus[<?= $index; ?>][description]" required><?= $menu->description; ?></textarea>
        
        <label>Prix:</label>
        <input type="text" name="menus[<?= $index; ?>][prix]" value="<?= $menu->prix; ?>" required>
        
        <label>Éléments:</label>
        <select name="menus[<?= $index; ?>][elements][]" multiple>
          <?php foreach ($plats as $platIndex => $plat): ?>
            <option value="<?= $platIndex; ?>" <?= in_array($platIndex, $menu->elements) ? 'selected' : ''; ?>><?= $plat->nom; ?></option>
          <?php endforeach; ?>
        </select>
        <button type="button" onclick="removeMenu(this)">Supprimer</button>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="btn btn-2" type="button" onclick="addMenu()">Ajouter un menu</button>

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
  <button class="btn btn-2" type="submit">Modifier le Restaurant</button>
</form>

<?php include 'views/includes/footer.php'; ?>


<script>
  let descriptionCount = <?= count($restaurant->coordonnees->description->paragraphes); ?>;
  let platCount = <?= count($restaurant->carte->plats); ?>;
  let menuCount = <?= count($restaurant->menus); ?>;
  let plats = <?= json_encode($restaurant->carte->plats); ?>;
  let menus = <?= json_encode($restaurant->menus); ?>;
</script>

<script src="public/js/restaurants.js"></script>


