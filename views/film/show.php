<?php include 'views/includes/header.php'; ?>

<h1 class="title">Détails du Film</h1>
<h2><?php echo $film->titre; ?></h2>
<p><strong>Durée:</strong> <?= $film->duree_heures . 'h ' . $film->duree_minutes . 'mn'; ?></p>
<p><strong>Genres:</strong> <?= implode(', ', $film->genres); ?></p>
<p><strong>Réalisateur:</strong> <?= $film->realisateur; ?></p>
<p><strong>Langue:</strong> <?= $film->langue; ?></p>
<p><strong>Acteurs:</strong> <?= implode(', ', $film->acteurs); ?></p>
<p><strong>Année:</strong> <?= $film->annee; ?></p>
<p><strong>Synopsis:</strong> <?= $film->synopsis; ?></p>

<h3>Horaires</h3>

<?php
// Organiser les horaires par jour
$horairesParJour = [];
foreach ($film->horaires as $horaire) {
    $jour = $horaire['jour'];
    $heure = $horaire['heure'] . ':' . $horaire['minute'];
    if (!isset($horairesParJour[$jour])) {
        $horairesParJour[$jour] = [];
    }
    $horairesParJour[$jour][] = $heure;
}
?>

<table>
    <thead>
        <tr>
            <th>Jour</th>
            <th>Heures</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($horairesParJour as $jour => $heures): ?>
            <tr>
                <td><?= $jour; ?></td>
                <td><?= implode(' | ', $heures); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php?controller=film&action=index" class="btn">Retour à la liste</a>

<?php include 'views/includes/footer.php'; ?>
