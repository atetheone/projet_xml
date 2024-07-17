<?php require 'views/includes/header.php'; ?>

<h1 class="title">Login</h1>
<form method="POST">
    <label>Nom d'utilisateur</label>
    <input type="text" name="username" required>
    <br>
    <label>Mot de passe</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="Login">
</form>
<?php if (isset($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php require 'views/includes/footer.php'; ?>
