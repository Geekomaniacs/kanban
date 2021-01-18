<div class="item box draggable" draggable="true" ondragstart="onDragStart(event);"
  id="<?= $item['id'] ?>" >
  <p class="content" >
    <?= $item['name'] ?>
  </p>
  <p>
    date:
    <span class="tag">
      <input 
        type="date"
        value="<?= $item['date'] ?>"
        required
        disabled="<?= $locked ?>"
      />
    </span>
  </p>
  <p>
    propriétaire:
    <span class="tag">
      <?= $item['owner'] ?>
    </span>
  </p>
</div>