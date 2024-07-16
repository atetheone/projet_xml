<h1>Modifier le Film</h1>
<form method="POST" action="index.php?controller=film&action=edit&id=<?php echo $film['@attributes']['id']; ?>">
  <label>Titre</label>
  <input type="text" name="titre" value="<?php echo $film->titre; ?>" required>
  
  <label>Durée (heures)</label>
  <input type="number" name="duree_heures" value="<?php echo $film->duree['@attributes']['heures']; ?>" required>
  
  <label>Durée (minutes)</label>
  <input type="number" name="duree_minutes" value="<?php echo $film->duree['@attributes']['minutes']; ?>" required>
  
  <label>Genres</label>
  <input type="text" name="genres" value="<?php echo implode(', ', iterator_to_array($film->genres->genre)); ?>" required>
  
  <label>Réalisateur</label>
  <input type="text" name="realisateur" value="<?php echo $film->realisateur; ?>" required>
  
  <label>Langue</label>
  <input type="text" name="langue" value="<?php echo $film->langue; ?>" required>
  
  <label>Année</label>
  <input type="number" name="annee" value="<?php echo $film->annee; ?>" required>
  
  <label>Synopsis</label>
  <textarea name="synopsis" required><?php echo $film->synopsis; ?></textarea>
  
  <label>Acteurs</label>
  <input type="text" name="acteurs" value="<?php echo implode(', ', iterator_to_array($film->acteurs->acteur)); ?>" required>
  
  <label>Notes</label>
  <textarea name="notes"><?php echo implode('; ', array_map(function($note) {
      return $note['@attributes']['source'] . ':' . $note;
  }, iterator_to_array($film->notes->note))); ?></textarea>
  
  <label>Horaires</label>
  <textarea name="horaires"><?php echo implode('; ', array_map(function($horaire) {
      return $horaire['@attributes']['jour'] . ':' . $horaire['@attributes']['heure'] . ':' . $horaire['@attributes']['minute'];
  }, iterator_to_array($film->horaires->horaire))); ?></textarea>
  
  <input type="submit" value="Modifier le Film">
</form>
