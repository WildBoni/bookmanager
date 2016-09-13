<?php

  include_once 'dbconnect.php';

  $ud_ID = (int)$_POST["ID"];
  $name = $title = $surname = $other = $note = $categoryID = $language1ID = $language2ID = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $title = htmlspecialchars($_POST['title']);
    $surname = htmlspecialchars($_POST['surname']);
    $other = htmlspecialchars($_POST['other']);
    $note = htmlspecialchars($_POST['note']);
    $categoryID = htmlspecialchars($_POST['categoryID']);
    $language1ID = htmlspecialchars($_POST['language1ID']);
    $language2ID = htmlspecialchars($_POST['language2ID']);
  }

  $sql = "UPDATE item SET name = '$name', title = '$title', surname = '$surname',
    other = '$other', note = '$note', category = '$categoryID',
    language1 = '$language1ID', language2 = '$language2ID'
    WHERE id='$ud_ID'";

  if ($con->query($sql) === TRUE) {
      echo "<p>Record ($ud_ID) updated successfully</p><p><a href='view.php'>Back to Item View</a></p>";
  } else {
      echo "Error: ($ud_ID) Not Updated";
  }

  $con->close();

?>
