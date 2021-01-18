<nav class="navbar is-light" role="navigation" aria-label="main navigation">
  <div class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="/accueil">Kanbans</a>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
        <?php if (isset($_SESSION['login'])) { ?>
            <?= $_SESSION['login'] ?>
            <a class="button is-danger" href="../../controleur/Logout.php">
            <strong>Deconnexion</strong>
          </a>
          <?php } else { ?>
          <a class="button is-primary" href="/login">
            <strong>Connexion</strong>
          </a>
          <a class="button is-light" href="/register">
            Inscription
          </a>
          <?php }?>
        </div>
      </div>
    </div>
</nav>