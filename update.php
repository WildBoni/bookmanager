<?php

  include_once 'dbconnect.php';

  $ud_ID = (int)$_POST["ID"];
  $name = $title = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $title = htmlspecialchars($_POST['title']);
  }

  $sql = "UPDATE item SET name = '$name', title = '$title' WHERE id='$ud_ID'";

  if ($con->query($sql) === TRUE) {
      echo "Record ($ud_ID) updated successfully";
  } else {
      echo "Error: ($ud_ID) Not Updated";
  }

  $con->close();

?>
