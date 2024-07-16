<?php include 'views/includes/header.php'; ?>

<h1>Modifier le Restaurant</h1>
<form method="POST" action="index.php?controller=restaurant&action=edit&id=<?php echo $restaurant->id; ?>">
    <label>Nom</label>
    <input type="text" name="nom" value="<?php echo $restaurant->nom; ?>" readonly>
    
    <label>Adresse</label>
    <input type="text" name="adresse" value="<?php echo $restaurant->adresse; ?>" required>
    
    <label>Restaurateur</label>
    <input type="text" name="restaurateur" value="<?php echo $restaurant->restaurateur; ?>" required>
    
    <label>Description</label>
    <textarea name="description" required><?php echo $restaurant->description; ?></textarea>
    
    <label>Carte (Format: id, nom, type, prix, description; Séparez les plats par des points-virgules)</label>
    <textarea name="carte" required><?php echo implode('; ', array_map(function($plat) {
        return implode(', ', $plat);
    }, $restaurant->carte)); ?></textarea>
    
    <label>Menus (Format: titre, description, prix, items séparés par |; Séparez les menus par des points-virgules)</label>
    <textarea name="menus"><?php echo implode('; ', array_map(function($menu) {
        return $menu['titre'] . ', ' . $menu['description'] . ', ' . $menu['prix'] . ', ' . implode('|', $menu['items']);
    }, $restaurant->menus)); ?></textarea>
    
    <input type="submit" value="Modifier le Restaurant">
</form>

<?php include 'views/includes/footer.php'; ?>
