<?php
session_start();
session_destroy();
header("location:../vue/pages/index.php");
?>