<?php include 'views/includes/header.php'; ?>

<h1>Ajouter un Restaurant</h1>
<form method="POST" action="index.php?controller=restaurant&action=add">
    <label>Nom</label>
    <input type="text" name="nom" required>
    
    <label>Adresse</label>
    <input type="text" name="adresse" required>
    
    <label>Restaurateur</label>
    <input type="text" name="restaurateur" required>
    
    <label>Description</label>
    <textarea name="description" required></textarea>
    
    <label>Carte (Format: id, nom, type, prix, description; Séparez les plats par des points-virgules)</label>
    <textarea name="carte" required></textarea>
    
    <label>Menus (Format: titre, description, prix, items séparés par |; Séparez les menus par des points-virgules)</label>
    <textarea name="menus"></textarea>
    
    <input type="submit" value="Ajouter le Restaurant">
</form>

<?php include 'views/includes/footer.php'; ?>
