<?php
  require('../model/User.php');
  User::createUser($_POST['mail'], $_POST['password']);
  header('Location: /accueil');
?>
