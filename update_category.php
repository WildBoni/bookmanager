<?php

  include_once 'dbconnect.php';

  $ud_ID = (int)$_POST["ID"];
  $category = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = htmlspecialchars($_POST['category']);
  }

  $sql = "UPDATE category SET category = '$category'
    WHERE id='$ud_ID'";

  if ($con->query($sql) === TRUE) {
      echo "<p>Record ($ud_ID) updated successfully</p><p><a href='view_category.php'>Back to Item View</a></p>";
  } else {
      echo "Error: ($ud_ID) Not Updated";
  }

  $con->close();

?>
