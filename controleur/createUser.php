<?php
  require('../modele/User.php');
  User::createUser($_POST['mail'], $_POST['password']);
  header('Location: ../vue/pages/index.php');
?>
