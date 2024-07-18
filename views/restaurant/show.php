<?php include 'views/includes/header.php'; ?>

<h1 class="title">Détails du Restaurant</h1>
<h2><?= $restaurant->coordonnees->nom; ?></h2>
<p><strong>Adresse:</strong> <?= $restaurant->coordonnees->adresse; ?></p>
<p><strong>Restaurateur:</strong> <?= $restaurant->coordonnees->restaurateur; ?></p>
<h3>Description</h3>
<?php foreach ($restaurant->coordonnees->description->paragraphes as $paragraphe): ?>
  <p class="paragraph">
    <!-- <img class="image" src="public/img/img-restau1.jpeg" alt="Image de restaurant" style="float: left;" width="400"> -->
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

<p><strong>Carte:</strong></p>
<ul>
  <?php foreach ($restaurant->carte->plats as $plat): ?>
    <li><?= $plat->nom . ' - ' . $plat->type . ' - ' . $plat->prix . ' ' . $plat->devise; ?></li>
  <?php endforeach; ?>
</ul>

<?php if (!empty($restaurant->menus)): ?>
  <p><strong>Menus:</strong></p>
  <?php foreach ($restaurant->menus as $menu): ?>
    <h3><?= $menu->titre; ?></h3>
    <p><?= $menu->description; ?></p>
    <ul>
      <?= $restaurant->carte->getPlatById("p1") ?>
      <?php foreach ($menu->elements as $element): ?>
        <?= $element->plat; ?>
        <li><?= $restaurant->carte->getPlatById($element->plat); ?></li>
      <?php endforeach; ?>
    </ul>
    <p><strong>Prix:</strong> <?= $menu->prix . ' ' . $menu->devise; ?></p>
  <?php endforeach; ?>
<?php endif; ?>

<a href="index.php?controller=restaurant&action=index" class="btn">Retour à la liste</a>

<?php include 'views/includes/footer.php'; ?>
