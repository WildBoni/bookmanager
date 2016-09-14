<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
  header("Location: index.php");
}

if($_POST['id']!=""):
    extract($_POST);
    $id=mysqli_real_escape_string($con,$id);
    $sql = $con->query("DELETE FROM language WHERE id='$id'");
endif;
?>
