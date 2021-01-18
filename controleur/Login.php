<?php
  session_start();
  require('../modele/User.php');
  echo $_POST['mail']." ".$_POST['password'];
  if (User::accountExist($_POST['mail'], $_POST['password'])) {
    $_SESSION['login'] = $_POST['mail'];
    echo "yes";
    header('Location: ../vue/pages/index.php');
  } else {
    echo "no";
  }
?>