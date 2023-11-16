<?php
    include("../../site/config.php");
    include("../../site/PHP/helper.php");
  
  if ($_SESSION['id'] == 0) {
    header("Location: /login/");
    die();
  }
  
  $id = $_SESSION['id'];
  $currentUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '" . $id . "'";
  $currentUserQuery = $conn->query($currentUserSQL);
  $currentUserRow = $currentUserQuery->fetch_assoc();
  $power = $currentUserRow['power'];
  
?>