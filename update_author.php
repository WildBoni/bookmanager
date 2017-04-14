<?php
  include_once 'dbconnect.php';

  $ud_ID = (int)$_POST["ID"];

  $name = $surname = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
  }

	$sql2 = "UPDATE author SET name = '$name', surname = '$surname' WHERE id='$ud_ID'";

	if ($con->query($sql2) === TRUE) {
    echo "<p>Record ($ud_ID) updated successfully</p><p><a href='javascript:history.go(-2);'>Back to Item View</a></p>";
  } else {
    echo "Error: ($ud_ID) Not Updated";
  }

  $con->close();

?>
