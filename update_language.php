<?php
  include_once 'dbconnect.php';

  $ud_ID = (int)$_POST["ID"];
  $language = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $language = htmlspecialchars($_POST['language']);
  }

  $sql = "UPDATE language SET language = '$language'
    WHERE id='$ud_ID'";

  if ($con->query($sql) === TRUE) {
    echo "<p>Record ($ud_ID) updated successfully</p><p><a href='view_language.php'>Back to Item View</a></p>";
  } else {
    echo "Error: ($ud_ID) Not Updated";
  }

  $con->close();

?>
