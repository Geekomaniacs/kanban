<?php $title = 'Ajout d\'un kanban'; ?>

<?php ob_start(); ?>

<section class="hero is-primary is-fullheight">
  <div class="hero-body">
    <div class="container">
          <form action="" class="box">
            <div class="field">
              <input type="text" placeholder="Nom du kanban" class="input" required>
            </div>
            <div class="field">
              <input type="text" placeholder="colonnes doivent être séparé par des colonnes" class="input" required>
            </div>
            <div class="field">
              <label for="access">Privé
                <input type="checkbox">
              </label>
            </div>
      </label>

            <div class="field">
              <button class="button is-success">
                Ajouter
              </button>
            </div>
          </form>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('../layout/template.php'); ?>