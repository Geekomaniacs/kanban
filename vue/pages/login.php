<?php $title = 'Connexion'; ?>

<?php ob_start(); ?>

<section class="hero is-primary is-fullheight">
  <div class="hero-body">
    <div class="container">
          <form action="../controleur/Login.php" class="box" method="post">
            <div class="field">
              <input type="email" placeholder="Adresse e-mail" class="input" name="mail" required>
            </div>
            <div class="field">
              <input type="password" placeholder="Mot de passe" class="input" name="password" required>
            </div>
            <div class="field">
              <button class="button is-success">
                Connexion
              </button>
            </div>
          </form>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('../vue/layout/template.php'); ?>
