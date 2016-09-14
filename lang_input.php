<?php
  include_once 'dbconnect.php';

  $name = $title = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lang = htmlspecialchars($_POST['lang']);
  }

  $sql = "INSERT INTO language (language)
  VALUES ('$lang')";

  if ($con->query($sql) === TRUE) {
    echo "<p>New language created successfully</p><p><a href='view_language.php'>Back to Language View</a></p>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $con->close();
?>
