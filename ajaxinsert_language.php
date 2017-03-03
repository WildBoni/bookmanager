<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $language = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $language = htmlspecialchars($_POST['lang']);
  }

  $sql = "INSERT INTO language (language)
  VALUES ('$language')";

  if ($con->query($sql) === TRUE) {
    echo "<p>New language created successfully</p>";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();
?>
