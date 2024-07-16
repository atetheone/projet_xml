<?php include 'views/includes/header.php'; ?>

<h1>Modifier le Film</h1>
<form method="POST" action="index.php?controller=film&action=edit&id=<?php echo $film->id; ?>">
  <label>Titre</label>
  <input type="text" name="titre" value="<?php echo $film->titre; ?>" required>
  
  <label>Durée (heures)</label>
  <input type="number" name="duree_heures" value="<?php echo $film->duree_heures; ?>" required>
  
  <label>Durée (minutes)</label>
  <input type="number" name="duree_minutes" value="<?php echo $film->duree_minutes; ?>" required>
  
  <label>Genres</label>
  <input type="text" name="genres" value="<?php echo implode(', ', $film->genres); ?>" required>
  
  <label>Réalisateur</label>
  <input type="text" name="realisateur" value="<?php echo $film->realisateur; ?>" required>
  
  <label>Langue</label>
  <input type="text" name="langue" value="<?php echo $film->langue; ?>" required>
  
  <label>Année</label>
  <input type="number" name="annee" value="<?php echo $film->annee; ?>" required>
  
  <label>Synopsis</label>
  <textarea name="synopsis" required><?php echo $film->synopsis; ?></textarea>
  
  <label>Acteurs</label>
  <input type="text" name="acteurs" value="<?php echo implode(', ', $film->acteurs); ?>" required>
  
  <label>Notes</label>
  <textarea name="notes"><?php echo implode('; ', array_map(function($note) {
      return $note['source'] . ':' . $note['text'];
  }, $film->notes)); ?></textarea>
  
  <label>Horaires</label>
  <textarea name="horaires"><?php echo implode('; ', array_map(function($horaire) {
      return $horaire['jour'] . ':' . $horaire['heure'] . ':' . $horaire['minute'];
  }, $film->horaires)); ?></textarea>
  
  <input type="submit" value="Modifier le Film">
</form>

<?php include 'views/includes/footer.php'; ?>