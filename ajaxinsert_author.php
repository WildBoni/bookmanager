<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $name = $surname = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name= htmlspecialchars($_POST['name']);
    $surname= htmlspecialchars($_POST['surname']);
  }

  $sql = "INSERT INTO author (name, surname, other)
  VALUES ('$name', '$surname', '')";

  if ($con->query($sql) === TRUE) {
    echo "<p>New category created successfully</p>";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();

?>
