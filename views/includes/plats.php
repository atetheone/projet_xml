<div id="plats">
  <div class="plat">
    <!-- Champ caché pour l'ID du plat -->
    <input type="hidden" id="platId">
    
    <label>Nom du plat:</label>
    <input type="text" id="platNom">

    <label>Type:</label>
    <input type="text" id="platType">

    <label>Prix:</label>
    <input type="text" id="platPrix">

    <label>Devise:</label>
    <input type="text" id="platDevise">

    <label>Description:</label>
    <textarea id="platDescription"></textarea>
    <button class="btn btn-2" type="button" onclick="addPlat()">Ajouter un plat</button>
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
</div>