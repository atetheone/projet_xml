<?php include 'views/includes/header.php'; ?>

<h1 class="title">Modifier le Restaurant</h1>
<form method="POST" action="index.php?controller=restaurant&action=edit&id=<?= $restaurant->id; ?>">
    <label>Nom</label>
    <input type="text" name="nom" value="<?= $restaurant->coordonnees->nom; ?>" readonly>
    
    <label>Adresse</label>
    <input type="text" name="adresse" value="<?= $restaurant->coordonnees->adresse; ?>" required>
    
    <label>Restaurateur</label>
    <input type="text" name="restaurateur" value="<?= $restaurant->coordonnees->restaurateur; ?>" required>
    
    <label>Description:</label>
    <textarea name="description" required><?php echo $this->descriptionToString($restaurant->coordonnees->description); ?></textarea>

    <label>Carte:</label>
    <textarea name="carte" required>
      <?= implode('; ', array_map(function($plat) {
        return implode(', ', $plat);
      }, $restaurant->carte)); ?>
    </textarea>
    <textarea name="carte" required><?php echo $restaurant->carte; ?></textarea>
    <label>Devise:</label>
    <input type="text" name="devise" value="<?php echo $restaurant->carte->devise; ?>" required>

    <label>Menus:</label>
    <textarea name="menus"><?php echo $restaurant->menus; ?></textarea>

    
    
    
    <input type="submit" value="Modifier le Restaurant">
</form>

<?php include 'views/includes/footer.php'; ?>
