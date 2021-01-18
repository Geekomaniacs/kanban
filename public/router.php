<?php

define('BASE', '../vue/pages/');

$section = explode("/", $_GET['url']);

if ($section[0] == 'accueil') {
  require (BASE . 'index.php');
} elseif ($section[0] == 'kanban') {
  require (BASE . 'kanban.php');
} elseif ($section[0] == 'login') {
  require (BASE . 'login.php');
} elseif ($section[0] == 'register') {
  require (BASE . 'register.php');
} elseif ($section[0] == 'addKanban') {
  require (BASE . 'addKanban.php');
} else {
  echo "page introuvable";
}
?>