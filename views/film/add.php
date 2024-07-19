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
  
  <label>Acteurs *</label>
  <input type="text" name="acteurs" placeholder="Séparez par des virgules" required>
  
  <label>Notes (sur 5)</label>
  <textarea name="notes" placeholder="Format: source:note; Séparez par des points virgules"></textarea>
  
  <label>Horaires</label>
  <textarea name="horaires" placeholder="Format: jour:heure:minute; Séparez par des points virgules"></textarea>
  
  <input type="submit" value="Ajouter le Film">
</form>

<?php include 'views/includes/footer.php'; ?>