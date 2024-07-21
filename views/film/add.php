<?php include 'views/includes/header.php'; ?>

<h1 class="title">Ajouter un Film</h1>
<form class="add-form" method="POST" action="index.php?controller=film&action=add">
  <label>Titre *</label>
  <input type="text" name="titre" required>

  <label>Durée (heures) *</label>
  <input type="number" name="duree_heures" min="0" max="23" required>

  <label>Durée (minutes) *</label>
  <input type="number" name="duree_minutes" min="0" max="59" step="1" required>

  
  <label>Genres *</label>
  <input type="text" name="genres" placeholder="Séparez par des virgules" required>
  
  <label>Réalisateur *</label>
  <input type="text" name="realisateur" required>
  
  <label>Langue *</label>
  <input type="text" name="langue" required>
  
  <label>Année *</label>
  <input type="number" name="annee" required>
  
  <label>Synopsis *</label>
  <textarea name="synopsis" required></textarea>
  
  <label>Acteurs * (acteur1, acteur2, ...)</label>
  <input type="text" name="acteurs" placeholder="Séparez par des virgules" required>
  
  <label>Notes (sur 5)</label>
  <textarea name="notes" placeholder="Format: source:note; Séparez par des points virgules"></textarea>
  
  <!-- <label>Horaires</label> -->
  <!-- <textarea name="horaires" placeholder="Format: jour:heure:minute; Séparez par des points virgules"></textarea> -->
  <!-- <div id="horaires">
    Les horaires ajoutés seront affichés ici
  </div>
  <button class="btn btn-2" type="button" onclick="addHoraire()">Ajouter un horaire</button> -->
  <div class="container">
    <!-- Formulaire d'ajout d'horaire -->
    <div>
      <h3>Ajouter un horaire</h3>
      <div id="horaire-form">
        <label>Jour</label>
        <select id="jour" required>
          <option value="lundi">Lundi</option>
          <option value="mardi">Mardi</option>
          <option value="mercredi">Mercredi</option>
          <option value="jeudi">Jeudi</option>
          <option value="vendredi">Vendredi</option>
          <option value="samedi">Samedi</option>
          <option value="dimanche">Dimanche</option>
        </select>
        <label>Heure</label>
        <input type="number" id="heure" placeholder="Heure"  min="0" max="23">
        <label>Minute</label>
        <input type="number" id="minute" placeholder="Minute" min="0" max="59">
        <button class="btn btn-2" type="button" onclick="addHoraire()">Ajouter un horaire</button>
      </div>
    </div>

    <!-- Tableau des horaires -->
    <div>
      <h3>Horaires existants</h3>
      <table id="horaires-table">
        <thead>
          <tr>
            <th>Jour</th>
            <th>Heure</th>
            <th>Minute</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Les horaires ajoutés seront affichés ici -->
        </tbody>
      </table>
    </div>
  </div>
  
  <input type="submit" value="Ajouter le Film">
</form>

<?php include 'views/includes/footer.php'; ?>

<?php if (isset($film->horaires)): ?>
  <script>
    const horaires = <?= json_encode($film->horaires); ?>;
  </script>
  <?php else: ?>
  <script>
    const horaires = [];
  </script>
<?php endif; ?>

<script src="public/js/films.js"></script>