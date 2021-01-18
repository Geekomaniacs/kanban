<?php $title = 'Kanban'; ?>
<?php session_start() ?>
<?php ob_start(); ?>

<main class="kanbansPage">
  <?php 
  require('../model/User.php');
  if (isset($_SESSION['login'])) {
    $name = "Personnels";
    $kanbans = array (
      array("name" => "se", "id" => "s5"),
      array("name" => "p", "id" => "s2"),
      array("name" => "mpoo", "id" => "s3"),
      array("name" => "pop", "id" => "s4")
    );
    require("../vue/components/kanbanList.php");
    require("../vue/components/addKanban.php");

    $kanbans = array (
      array("name" => "se", "id" => "s5"),
      array("name" => "p", "id" => "s2"),
      array("name" => "mpoo", "id" => "s3"),
      array("name" => "pop", "id" => "s4")
    );
    $name = "Accessibles";
    require("../vue/components/kanbanList.php");
  }
  $name = "Publics";
  $kanbans = array (
    array("name" => "se", "id" => 1),
    array("name" => "p", "id" => 2),
    array("name" => "mpoo", "id" => 3),
    array("name" => "pop", "id" => 4)
  );
  require("../vue/components/kanbanList.php");
  if (isset($_SESSION['login'])) {
    $locked = true;
    $items = array (
      array("id" => 1, "name" => "SE", "date" => "2017-07-22", "owner" => "pop1@pop.fr"),
      array("id" => 2, "name" => "SE2", "date" => "2017-07-22", "owner" => "pop2@pop.fr"),
      array("id" => 3, "name" => "SE3", "date" => "2017-07-22", "owner" => "pop3@pop.fr"),
      array("id" => 5, "name" => "SE4", "date" => "2017-07-22", "owner" => "pop4@pop.fr")
    );
    require("../vue/components/tasks.php");
  }
  ?>
</main>

<?php $content = ob_get_clean(); ?>
<?php require('../vue/layout/template.php'); ?>