<?php $title = 'Kanban'; ?>

<?php ob_start(); ?>

<div class="columns">
  <?php
  $columns = array(
    array(
      "name" => "C1",
      "items" => array (
        array("id" => 1, "name" => "SE", "date" => "2017-07-22", "owner" => "pop1@pop.fr"),
        array("id" => 2, "name" => "SE2", "date" => "2017-07-22", "owner" => "pop2@pop.fr"),
        array("id" => 3, "name" => "SE3", "date" => "2017-07-22", "owner" => "pop3@pop.fr"),
        array("id" => 5, "name" => "SE4", "date" => "2017-07-22", "owner" => "pop4@pop.fr")
      )),
    array(
      "name" => "C2",
      "items" => array (
        array("id" => 1, "name" => "SE", "date" => "2017-07-22", "owner" => "pop1@pop.fr"),
        array("id" => 2, "name" => "SE2", "date" => "2017-07-22", "owner" => "pop2@pop.fr"),
        array("id" => 3, "name" => "SE3", "date" => "2017-07-22", "owner" => "pop3@pop.fr"),
        array("id" => 5, "name" => "SE4", "date" => "2017-07-22", "owner" => "pop4@pop.fr")
      )),
    array(
      "name" => "C3",
      "items" => array (
        array("id" => 1, "name" => "SE", "date" => "2017-07-22", "owner" => "pop1@pop.fr"),
        array("id" => 2, "name" => "SE2", "date" => "2017-07-22", "owner" => "pop2@pop.fr"),
        array("id" => 3, "name" => "SE3", "date" => "2017-07-22", "owner" => "pop3@pop.fr"),
        array("id" => 5, "name" => "SE4", "date" => "2017-07-22", "owner" => "pop4@pop.fr")
      )),
    array(
      "name" => "C4",
      "items" => array (
        array("id" => 1, "name" => "SE", "date" => "2017-07-22", "owner" => "pop1@pop.fr"),
        array("id" => 2, "name" => "SE2", "date" => "2017-07-22", "owner" => "pop2@pop.fr"),
        array("id" => 3, "name" => "SE3", "date" => "2017-07-22", "owner" => "pop3@pop.fr"),
        array("id" => 5, "name" => "SE4", "date" => "2017-07-22", "owner" => "pop4@pop.fr")
      )),
  ); 
  foreach($columns as $column):
    require("../vue/components/column.php");
  endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('../vue/layout/template.php'); ?>