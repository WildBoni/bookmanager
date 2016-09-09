<?php
  include_once 'dbconnect.php';
  $name = $title = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $title = htmlspecialchars($_POST['title']);
    $categoryID = htmlspecialchars($_POST['categoryID']);
  }

  $sql = "INSERT INTO item (name, title, category)
  VALUES ('$name', '$title', '$categoryID')";

  if ($con->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();
?>
