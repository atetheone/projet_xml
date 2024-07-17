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
<p>
  <strong>Horaires:</strong> 
  <?= implode('; ', array_map(function($horaire) {
        return $horaire['jour'] . ':' . $horaire['heure'] . ':' . $horaire['minute'];
  }, $film->horaires)); ?>
</p>
<a href="index.php?controller=film&action=index" class="btn">Retour à la liste</a>

    
<?php include 'views/includes/footer.php'; ?>
