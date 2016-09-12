<?php
  include_once 'dbconnect.php';
  $name = $title = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $title = htmlspecialchars($_POST['title']);
    $categoryID = htmlspecialchars($_POST['categoryID']);
    $languageID = htmlspecialchars($_POST['languageID']);
  }

  $sql = "INSERT INTO item (name, title, category, language1)
  VALUES ('$name', '$title', '$categoryID', '$languageID')";

  if ($con->query($sql) === TRUE) {
    echo "<p>New item created successfully</p><p><a href='view.php'>Back to Item View</a></p>";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();
?>
