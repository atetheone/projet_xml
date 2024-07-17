<?php include 'views/includes/header.php'; ?>

<h1>Films</h1>
<?php if (AuthController::checkAdmin()): ?>
  <a href="index.php?controller=film&action=add" class="btn">Ajouter un Film</a>
<?php endif; ?>

<table>
  <tr>
    <th>ID</th>
    <th>Titre</th>
    <th>Durée</th>
    <th>Genres</th>
    <th>Réalisateur</th>
    <th>Langue</th>
    <th>Année</th>
    <?php if (AuthController::checkAdmin()): ?>
      <th>Actions</th>
    <?php endif; ?>
  </tr>
  <?php foreach ($films as $film): ?>
  <tr>
    <td><?= $film->id; ?></td>
    <td><?= $film->titre; ?></td>
    <td><?= $film->duree_heures . 'h ' . $film->duree_minutes . 'm'; ?></td>
    <td>
      <?php foreach ($film->genres as $genre): ?>
        <?= $genre . ' '; ?>
      <?php endforeach; ?>
    </td>
    <td><?= $film->realisateur; ?></td>
    <td><?= $film->langue; ?></td>
    <td><?= $film->annee; ?></td>
    <?php if (AuthController::checkAdmin()): ?>
      <td class="action-buttons">
        <a href="index.php?controller=film&action=edit&id=<?= $film->id; ?>" class="edit"><i class="fas fa-edit"></i> Modifier</a>
        <a href="index.php?controller=film&action=delete&id=<?= $film->id; ?>" class="delete"><i class="fas fa-trash-alt"></i> Supprimer</a>
      </td>
    <?php endif; ?>

  </tr>
  <?php endforeach; ?>
</table>

<?php include 'views/includes/footer.php'; ?>