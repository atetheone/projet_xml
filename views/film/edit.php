<?php include 'views/includes/header.php'; ?>

<h1>Modifier le Film</h1>
<form method="POST" action="index.php?controller=film&action=edit&id=<?= $film->id; ?>">
    <label>Titre</label>
    <input type="text" name="titre" value="<?= $film->titre; ?>" required>
    
    <label>Durée (heures)</label>
    <input type="number" name="duree_heures" value="<?= $film->duree_heures; ?>" required>
    
    <label>Durée (minutes)</label>
    <input type="number" name="duree_minutes" value="<?= $film->duree_minutes; ?>" required>
    
    <label>Genres</label>
    <input type="text" name="genres" value="<?= implode(', ', $film->genres); ?>" required>
    
    <label>Réalisateur</label>
    <input type="text" name="realisateur" value="<?= $film->realisateur; ?>" required>
    
    <label>Langue</label>
    <input type="text" name="langue" value="<?= $film->langue; ?>" required>
    
    <label>Année</label>
    <input type="number" name="annee" value="<?= $film->annee; ?>" required>
    
    <label>Synopsis</label>
    <textarea name="synopsis" required><?= $film->synopsis; ?></textarea>
    
    <label>Acteurs</label>
    <input type="text" name="acteurs" value="<?= implode(', ', $film->acteurs); ?>" required>
    
    <label>Notes</label>
    <textarea name="notes"><?= implode('; ', array_map(function($note) {
        return $note['source'] . ':' . $note['text'];
    }, $film->notes)); ?></textarea>
    
    <label>Horaires</label>
    <textarea name="horaires"><?= implode('; ', array_map(function($horaire) {
        return $horaire['jour'] . ':' . $horaire['heure'] . ':' . $horaire['minute'];
    }, $film->horaires)); ?></textarea>
    
    <input type="submit" value="Modifier le Film">
</form>

<?php include 'views/includes/footer.php'; ?>