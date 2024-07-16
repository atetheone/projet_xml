<?php include 'views/includes/header.php'; ?>

<h1>Films</h1>
<a href="index.php?controller=film&action=add" class="btn">Ajouter un Film</a>
<table>
  <tr>
    <th>ID</th>
    <th>Titre</th>
    <th>Durée</th>
    <th>Genres</th>
    <th>Réalisateur</th>
    <th>Langue</th>
    <th>Année</th>
    <th>Actions</th>
  </tr>
  <?php foreach ($films as $film): ?>
  <tr>
    <td><?php echo $film->id; ?></td>
    <td><?php echo $film->titre; ?></td>
    <td><?php echo $film->duree_heures . 'h ' . $film->duree_minutes . 'm'; ?></td>
    <td>
      <?php foreach ($film->genres as $genre): ?>
        <?php echo $genre . ' '; ?>
      <?php endforeach; ?>
    </td>
    <td><?php echo $film->realisateur; ?></td>
    <td><?php echo $film->langue; ?></td>
    <td><?php echo $film->annee; ?></td>
    <td class="action-buttons">
      <a href="index.php?controller=film&action=edit&id=<?php echo $film->id; ?>" class="edit"><i class="fas fa-edit"></i> Modifier</a>
      <a href="index.php?controller=film&action=delete&id=<?php echo $film->id; ?>" class="delete"><i class="fas fa-trash-alt"></i> Supprimer</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

<?php include 'views/includes/footer.php'; ?>