<div id="menus">
  <div class="menu">
    <label>Titre du menu:</label>
    <input type="text" id="menuTitre">

    <label>Description:</label>
    <textarea id="menuDescription"></textarea>

    <label>Prix:</label>
    <input type="text" id="menuPrix">

    <label>Devise:</label>
    <input type="text" id="menuDevise">

    <label>Éléments:</label>

    <div class="menu-elements-container">
      <select id="menuElements" multiple>
        <?php if (isset($restaurant->carte->plats)) : ?>
          <?php foreach ($restaurant->carte->plats as $plat): ?>
            <option value="<?= $plat->id; ?>"><?= htmlspecialchars($plat->nom); ?></option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
    </div>
    <button class="btn btn-2" type="button" onclick="addMenu()">Ajouter un menu</button>
  </div>

  <h3>Menus Ajoutés</h3>
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