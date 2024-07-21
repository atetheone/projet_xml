<?php include 'views/includes/header.php'; ?>

<h1 class="title">Modifier le Film</h1>
<form method="POST" action="index.php?controller=film&action=edit&id=<?= $film->id; ?>">
    <label>Titre</label>
    <input type="text" name="titre" value="<?= $film->titre; ?>" required>
    
    <label>Durée (heures)</label>
    <input type="number" name="duree_heures" value="<?= $film->duree_heures; ?>" required>
    
    <label>Durée (minutes)</label>
    <input type="number" name="duree_minutes" value="<?= $film->duree_minutes; ?>" required>
    
    <label>Genres (genre1, genre2, ...)</label>
    <input type="text" name="genres" value="<?= implode(', ', $film->genres); ?>" required>
    
    <label>Réalisateur</label>
    <input type="text" name="realisateur" value="<?= $film->realisateur; ?>" required>
    
    <label>Langue</label>
    <input type="text" name="langue" value="<?= $film->langue; ?>" required>
    
    <label>Année</label>
    <input type="number" name="annee" value="<?= $film->annee; ?>" required>
    
    <label>Synopsis</label>
    <textarea name="synopsis" required><?= $film->synopsis; ?></textarea>
    
    <label>Acteurs (acteur1, acteur2, ...)</label>
    <input type="text" name="acteurs" value="<?= implode(', ', $film->acteurs); ?>" required>
    
    <label>Notes (source:note;)</label>
    <textarea name="notes"><?= implode('; ', array_map(function($note) {
        return $note['source'] . ':' . $note['text'];
    }, $film->notes)); ?></textarea>

    <div class="container">
        <!-- Formulaire d'ajout d'horaire -->
        <div>
            <h3>Ajouter un horaire</h3>
            <div id="horaire-form">
                <label>Jour</label>
                <select id="jour">
                    <option value="lundi">Lundi</option>
                    <option value="mardi">Mardi</option>
                    <option value="mercredi">Mercredi</option>
                    <option value="jeudi">Jeudi</option>
                    <option value="vendredi">Vendredi</option>
                    <option value="samedi">Samedi</option>
                    <option value="dimanche">Dimanche</option>
                </select>
                <label>Heure</label>
                <input type="number" id="heure" placeholder="Heure" min="0" max="23">
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
    
    <!-- <label>Horaires</label> -->
    
    <input type="submit" value="Modifier le Film">
</form>

<?php include 'views/includes/footer.php'; ?>

<script>
    const horaires = <?= json_encode($film->horaires); ?>;
</script>
<script src="public/js/films.js"></script>