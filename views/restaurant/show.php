<?php include 'views/includes/header.php'; ?>

<h1 class="title">Détails du Restaurant</h1>
<h2><?= $restaurant->nom; ?></h2>
<p><strong>Adresse:</strong> <?= $restaurant->adresse; ?></p>
<p><strong>Restaurateur:</strong> <?= $restaurant->restaurateur; ?></p>
<h3>Description</h3>
<?php foreach ($restaurant->description as $element): ?>
  <?php if ($element instanceof Paragraphe): ?>
    <p><?= $element->content; ?></p>
  <?php elseif ($element instanceof Image): ?>
    <img src="<?= $element->url; ?>" style="float:<?= $element->position; ?>;">
  <?php elseif ($element instanceof Liste): ?>
    <ul>
      <?php foreach ($element->items as $item): ?>
        <li><?= $item->content; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php elseif ($element instanceof Important): ?>
    <p><strong><?= $element->content; ?></strong></p>
  <?php endif; ?>
<?php endforeach; ?>
<a href="index.php?controller=restaurant&action=index" class="btn">Retour à la liste</a>

<?php include 'views/includes/footer.php'; ?>
