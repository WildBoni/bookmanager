<?php
  include_once 'dbconnect.php';

  $name = $title = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat = htmlspecialchars($_POST['cat']);
  }

  $sql = "INSERT INTO category (category)
  VALUES ('$cat')";

  if ($con->query($sql) === TRUE) {
    echo "<p>New category created successfully</p><p><a href='view.php'>Back to Item View</a></p>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $con->close();
?>
