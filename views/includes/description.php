<div id="description">
  <?php foreach ($restaurant->coordonnees->description->paragraphes as $index => $paragraphe): ?>
    <?php foreach ($paragraphe->content as $contentIndex => $item): ?>
      <div class="description-item">
        <select name="description[<?= $index; ?>][<?= $contentIndex; ?>][type]" required>
          <option value="texte" <?= $item instanceof Texte ? 'selected' : ''; ?>>Texte</option>
          <option value="image" <?= $item instanceof Image ? 'selected' : ''; ?>>Image</option>
          <option value="liste" <?= $item instanceof Liste ? 'selected' : ''; ?>>Liste</option>
          <option value="important" <?= $item instanceof Important ? 'selected' : ''; ?>>Important</option>
        </select>
        <?php if ($item instanceof Texte): ?>
          <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required><?= htmlspecialchars($item->texte); ?></textarea>
        <?php elseif ($item instanceof Image): ?>
          <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required>url:<?= htmlspecialchars($item->url); ?>, position:<?= htmlspecialchars($item->position); ?></textarea>
        <?php elseif ($item instanceof Liste): ?>
          <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required><?= htmlspecialchars(implode(', ', $item->items)); ?></textarea>
        <?php elseif ($item instanceof Important): ?>
          <textarea name="description[<?= $index; ?>][<?= $contentIndex; ?>][content]" required><?= htmlspecialchars($item->texte); ?></textarea>
        <?php endif; ?>
        <button class="btn btn-2" type="button" onclick="removeDescriptionItem(this)">Supprimer</button>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
</div>