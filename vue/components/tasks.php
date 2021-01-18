<section>
      <h2 class="title is-2">Tâches</h2>
      <div class="items">
      <?php
        foreach($items as $item): 
          require("item.php");
        endforeach;
      ?>
      </div>
</section>