<h1>Films</h1>
<a href="index.php?controller=film&action=add">Ajouter un Film</a>
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
    <td><?php echo $film['@attributes']['id']; ?></td>
    <td><?php echo $film->titre; ?></td>
    <td><?php echo $film->duree['@attributes']['heures'] . 'h ' . $film->duree['@attributes']['minutes'] . 'm'; ?></td>
    <td>
      <?php foreach ($film->genres->genre as $genre): ?>
        <?php echo $genre . ' '; ?>
      <?php endforeach; ?>
    </td>
    <td><?php echo $film->realisateur; ?></td>
    <td><?php echo $film->langue; ?></td>
    <td><?php echo $film->annee; ?></td>
    <td>
      <a href="index.php?controller=film&action=edit&id=<?php echo $film['@attributes']['id']; ?>">Modifier</a>
      <a href="index.php?controller=film&action=delete&id=<?php echo $film['@attributes']['id']; ?>">Supprimer</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
