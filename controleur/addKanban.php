<?php
  var_dump($_POST);
  require("../model/Kanban.php");
  $public = 0;
  if (isset($_POST['public'])) {
    $public = 1;
  }
  $owner = 1;
  $name = $_POST['name'];
  $participe = 1;
  // Kanban::createKanban($name, $owner, $public, $participe);
  Kanban::createKanban("monKanban", 2, true, array("Michel@mail", "JeanLuc@mail", "Martine@mail"));
?>