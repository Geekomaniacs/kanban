<div class="column" 
    ondragover="onDragOver(event);"
    ondrop="onDrop(event);">
  <div class="box">
  <?= $column['name'] ?>
  <?php 
  foreach($column['items'] as $item): 
    require("item.php");
  endforeach;
  require("addItem.php");
  ?>
  </div>
</div>