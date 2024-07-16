<h1>Ajouter un Film</h1>
<form method="POST" action="index.php?controller=film&action=add">
  <label>Titre</label>
  <input type="text" name="titre" required>

  <label>Durée (heures)</label>
  <input type="number" name="duree_heures" required>
  
  <label>Durée (minutes)</label>
  <input type="number" name="duree_minutes" required>
  
  <label>Genres</label>
  <input type="text" name="genres" placeholder="Séparez par des virgules" required>
  
  <label>Réalisateur</label>
  <input type="text" name="realisateur" required>
  
  <label>Langue</label>
  <input type="text" name="langue" required>
  
  <label>Année</label>
  <input type="number" name="annee" required>
  
  <label>Synopsis</label>
  <textarea name="synopsis" required></textarea>
  
  <label>Acteurs</label>
  <input type="text" name="acteurs" placeholder="Séparez par des virgules" required>
  
  <label>Notes</label>
  <textarea name="notes" placeholder="Format: source:note; Séparez par des virgules"></textarea>
  
  <label>Horaires</label>
  <textarea name="horaires" placeholder="Format: jour:heure:minute; Séparez par des virgules"></textarea>
  
  <input type="submit" value="Ajouter le Film">
</form>