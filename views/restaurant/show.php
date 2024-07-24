<?php include 'views/includes/header.php'; ?>

<h1 class="title">Détails du Restaurant</h1>
<h2><?= htmlspecialchars($restaurant->coordonnees->nom); ?></h2>
<p><strong>Adresse:</strong> <?= htmlspecialchars($restaurant->coordonnees->adresse); ?></p>
<p><strong>Restaurateur:</strong> <?= htmlspecialchars($restaurant->coordonnees->restaurateur); ?></p>
<h3>Description</h3>
<?php foreach ($restaurant->coordonnees->description->paragraphes as $paragraphe): ?>
  <div class="paragraph">
    <?php foreach ($paragraphe->content as $item): ?>
      <?php if ($item instanceof Texte): ?>
        <p><?= htmlspecialchars($item->texte); ?></p>
      <?php elseif ($item instanceof Image): ?>
        <img src="<?= htmlspecialchars($item->url); ?>" alt="Image de restaurant" class="float-<?= htmlspecialchars($item->position); ?>" width="200">
      <?php elseif ($item instanceof Liste): ?>
        <ul>
          <?php foreach ($item->items as $listItem): ?>
            <li><?= htmlspecialchars($listItem); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php elseif ($item instanceof Important): ?>
        <strong><?= htmlspecialchars($item->texte); ?></strong>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>


<h3>Carte</h3>
<div class="carte">
  <?php foreach ($restaurant->carte->plats as $plat): ?>
    <div class="carte-item">
      <h4><?= htmlspecialchars($plat->nom); ?></h4>
      <?php if (!empty($plat->description)): ?>
        <p><?= htmlspecialchars($plat->description); ?></p>
      <?php endif; ?>
      <p><strong>Type:</strong> <?= htmlspecialchars($plat->type); ?></p>
      <p><strong>Prix:</strong> <?= htmlspecialchars($plat->prix) . ' ' . htmlspecialchars($plat->devise); ?></p>
    </div>
  <?php endforeach; ?>
</div>

<?php if (!empty($restaurant->menus)): ?>
  <h3>Menus</h3>
  <?php foreach ($restaurant->menus as $menu): ?>
    <div class="menu-item">
      <h4><?= htmlspecialchars($menu->titre); ?></h4>
      <?php if (!empty($menu->description)): ?>
        <p><?= htmlspecialchars($menu->description); ?></p>
      <?php endif; ?>
      <ul>
        <?php foreach ($menu->elements as $element): ?>
          <?php $elemPlat = $restaurant->carte->getPlatById($element); ?>
          <li><?= htmlspecialchars($elemPlat->nom) . ' - ' . htmlspecialchars($elemPlat->type) . ' - ' . htmlspecialchars($elemPlat->prix) . ' ' . htmlspecialchars($elemPlat->devise); ?></li>
        <?php endforeach; ?>
      </ul>
      <p><strong>Prix:</strong> <?= htmlspecialchars($menu->prix) . ' ' . htmlspecialchars($menu->devise); ?></p>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<a href="index.php?controller=restaurant&action=index" class="btn">Retour à la liste</a>

<?php include 'views/includes/footer.php'; ?>
