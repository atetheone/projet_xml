<?php include 'views/includes/header.php'; ?>

<h1>Restaurants</h1>
<?php if (AuthController::checkAdmin()): ?>
    <a href="index.php?controller=restaurant&action=add" class="btn">Ajouter un Restaurant</a>
<?php endif; ?>

<table>
    <tr>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Restaurateur</th>
        <?php if (AuthController::checkAdmin()): ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($restaurants as $restaurant): ?>
    <tr>
        <td><?php echo $restaurant->nom; ?></td>
        <td><?php echo $restaurant->adresse; ?></td>
        <td><?php echo $restaurant->restaurateur; ?></td>

        <td class="action-buttons">
          <a href="index.php?controller=restaurant&action=show&id=<?php echo $restaurant->id; ?>" class="btn">Voir Détails</a>
          <?php if (AuthController::checkAdmin()): ?>
              <a href="index.php?controller=restaurant&action=edit&id=<?php echo $restaurant->id; ?>" class="edit"><i class="fas fa-edit"></i> Modifier</a>
              <a href="index.php?controller=restaurant&action=delete&id=<?php echo $restaurant->id; ?>" class="delete"><i class="fas fa-trash-alt"></i> Supprimer</a>
          <?php endif; ?>
        </td>   
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'views/includes/footer.php'; ?>
