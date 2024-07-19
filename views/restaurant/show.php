<?php include 'views/includes/header.php'; ?>

<h1 class="title">Détails du Restaurant</h1>
<h2><?= $restaurant->coordonnees->nom; ?></h2>
<p><strong>Adresse:</strong> <?= $restaurant->coordonnees->adresse; ?></p>
<p><strong>Restaurateur:</strong> <?= $restaurant->coordonnees->restaurateur; ?></p>
<h3>Description</h3>
<?php foreach ($restaurant->coordonnees->description->paragraphes as $paragraphe): ?>
  <p class="paragraph">
    <?php if ($paragraphe instanceof Image): ?>
      <img src="<?= $paragraphe->url; ?>" alt="Image de restaurant" style="float: <?= $paragraphe->position; ?>;">
    <?php elseif ($paragraphe instanceof Liste): ?>
      <ul>
        <?php foreach ($paragraphe->items as $item): ?>
          <li><?= $item; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php elseif ($paragraphe instanceof Important): ?>
      <strong><?= $paragraphe->texte; ?></strong>
    <?php else: ?>
      <?= $paragraphe; ?>
    <?php endif; ?>
  </p>
<?php endforeach; ?>

<h3>Carte</h3>
<div class="carte">
  <?php foreach ($restaurant->carte->plats as $plat): ?>
    <div class="carte-item">
      <h4><?= $plat->nom; ?></h4>
      <p><strong>Type:</strong> <?= $plat->type; ?></p>
      <p><strong>Prix:</strong> <?= $plat->prix . ' ' . $plat->devise; ?></p>
    </div>
  <?php endforeach; ?>
</div>

<?php if (!empty($restaurant->menus)): ?>
  <h3>Menus</h3>
  <?php foreach ($restaurant->menus as $menu): ?>
    <div class="menu-item">
      <h4><?= $menu->titre; ?></h4>
      <p><?= $menu->description; ?></p>
      <ul>
        <?php foreach ($menu->elements as $element): ?>
          <li><?= $element->nom . ' - ' . $element->type . ' - ' . $element->prix . ' ' . $element->devise; ?></li>
        <?php endforeach; ?>
      </ul>
      <p><strong>Prix:</strong> <?= $menu->prix . ' ' . $menu->devise; ?></p>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<a href="index.php?controller=restaurant&action=index" class="btn">Retour à la liste</a>

<?php include 'views/includes/footer.php'; ?>
