<?php
  include_once 'dbconnect.php';
  $name = $title = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $other = htmlspecialchars($_POST['other']);
    $note = htmlspecialchars($_POST['note']);
    $title = htmlspecialchars($_POST['title']);
    $categoryID = htmlspecialchars($_POST['categoryID']);
    $language1ID = htmlspecialchars($_POST['language1ID']);
    $language2ID = htmlspecialchars($_POST['language2ID']);
  }

  $sql = "INSERT INTO item (name, surname, other, note, title, category, language1, language2)
  VALUES ('$name', '$title', '$surname', '$other', '$note', '$categoryID', '$language1ID', '$language2ID')";

  if ($con->query($sql) === TRUE) {
    echo "<p>New item created successfully</p><p><a href='view.php'>Back to Item View</a></p>";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();
?>
