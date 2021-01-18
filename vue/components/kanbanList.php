<section>
      <h2 class="title is-2">Kanbans <?= $name ?></h2>
      <div class="kanbans">
      <?php foreach ($kanbans as $kanban): ?>
        <a href="kanban/<?= $kanban['id'] ?>">
          <button class="button is-outlined"><?= $kanban['name'] ?></button>
        </a>
      <?php endforeach; ?>
      </div>
</section>