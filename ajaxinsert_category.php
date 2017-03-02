<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $category = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = htmlspecialchars($_POST['cat']);
  }

  $sql = "INSERT INTO category (category)
  VALUES ('$category')";

  if ($con->query($sql) === TRUE) {
    echo "<p>New category created successfully</p>";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();

?>
